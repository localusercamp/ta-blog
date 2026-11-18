<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Facades\DB;
use App\Models\Category;
use App\Models\Post;
use DateTimeImmutable;
use PDO;

final class PostRepository
{
    public function getPostById(int $id): ?Post
    {
        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT *
            FROM posts
            WHERE id = ?
            LIMIT 1
        SQL);

        $stmt->execute([$id]);

        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return $this->hydrateMany([$row])[0];
    }

    /**
     * @return list<Post>
     */
    public function getPostsByCategory(
        int $categoryId,
        bool $sortByViews,
        int $limit,
        int $offset,
    ): array {
        $orderBy = $sortByViews
            ? 'p.views DESC, p.id DESC'
            : 'p.published_at DESC, p.id DESC';

        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT p.*
            FROM posts p
            INNER JOIN category_post cp ON cp.post_id = p.id
            WHERE cp.category_id = :category_id
            ORDER BY {$orderBy}
            LIMIT :limit OFFSET :offset
        SQL);

        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', max(1, $limit), PDO::PARAM_INT);
        $stmt->bindValue('offset', max(0, $offset), PDO::PARAM_INT);
        $stmt->execute();

        return $this->hydrateMany($stmt->fetchAll());
    }

    public function getPostCountByCategory(int $categoryId): int
    {
        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT COUNT(*)
            FROM category_post
            WHERE category_id = ?
        SQL);

        $stmt->execute([$categoryId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * @param list<int> $categoryIds
     * @return array<int, list<Post>>
     */
    public function getLatestPostsByCategories(array $categoryIds, int $limit): array
    {
        $categoryIds = array_values(array_unique(array_filter(
            array_map('intval', $categoryIds),
            static fn (int $id): bool => $id > 0,
        )));

        if ($categoryIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
        $limit = max(1, $limit);

        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT ranked.*
            FROM (
                SELECT p.*, cp.category_id,
                       ROW_NUMBER() OVER (
                           PARTITION BY cp.category_id
                           ORDER BY p.published_at DESC, p.id DESC
                       ) AS row_num
                FROM posts p
                INNER JOIN category_post cp ON cp.post_id = p.id
                WHERE cp.category_id IN ({$placeholders})
            ) AS ranked
            WHERE ranked.row_num <= ?
            ORDER BY ranked.category_id, ranked.row_num
        SQL);

        foreach ($categoryIds as $index => $categoryId) {
            $stmt->bindValue($index + 1, $categoryId, PDO::PARAM_INT);
        }

        $stmt->bindValue(count($categoryIds) + 1, $limit, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        $posts = $this->hydrateMany($rows);
        $grouped = [];

        foreach ($rows as $index => $row) {
            $grouped[(int) $row['category_id']][] = $posts[$index];
        }

        return $grouped;
    }

    /**
     * @return list<Post>
     */
    public function getSimilarPosts(Post $post): array
    {
        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT p.*
            FROM posts p
            INNER JOIN category_post cp ON cp.post_id = p.id
            WHERE cp.category_id IN (
                SELECT category_id
                FROM category_post
                WHERE post_id = :target_id
            )
            AND p.id <> :excluded_id
            GROUP BY p.id
            ORDER BY COUNT(*) DESC, p.published_at DESC, p.id DESC
        SQL);

        $stmt->bindValue('target_id', $post->id, PDO::PARAM_INT);
        $stmt->bindValue('excluded_id', $post->id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->hydrateMany($stmt->fetchAll());
    }

    public function incrementViews(int $id): void
    {
        $stmt = DB::pdo()->prepare(<<<SQL
            UPDATE posts
            SET views = views + 1
            WHERE id = ?
        SQL);

        $stmt->execute([$id]);
    }

    /**
     * @param list<array<string, mixed>> $rows
     * @return list<Post>
     */
    private function hydrateMany(array $rows): array
    {
        if ($rows === []) {
            return [];
        }

        $postIds = array_map(
            static fn (array $row): int => (int) $row['id'],
            $rows,
        );
        $categories = $this->getCategoriesByPostIds($postIds);

        return array_map(
            fn (array $row): Post => $this->hydrate(
                $row,
                $categories[(int) $row['id']] ?? [],
            ),
            $rows,
        );
    }

    /**
     * @param array<string, mixed> $row
     * @param list<Category> $categories
     */
    private function hydrate(array $row, array $categories): Post
    {
        return new Post(
            id: (int) $row['id'],
            title: (string) $row['title'],
            description: (string) $row['description'],
            content: (string) $row['content'],
            image: $row['image'] === null ? null : (string) $row['image'],
            views: (int) $row['views'],
            publishedAt: new DateTimeImmutable((string) $row['published_at']),
            categories: $categories,
        );
    }

    /**
     * @param list<int> $postIds
     * @return array<int, list<Category>>
     */
    private function getCategoriesByPostIds(array $postIds): array
    {
        if ($postIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($postIds), '?'));
        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT cp.post_id, c.id, c.title, c.description
            FROM category_post cp
            INNER JOIN categories c ON c.id = cp.category_id
            WHERE cp.post_id IN ({$placeholders})
            ORDER BY c.title
        SQL);

        $stmt->execute($postIds);

        $categories = [];

        while ($row = $stmt->fetch()) {
            $categories[(int) $row['post_id']][] = new Category(
                id: (int) $row['id'],
                title: (string) $row['title'],
                description: (string) $row['description'],
            );
        }

        return $categories;
    }
}
