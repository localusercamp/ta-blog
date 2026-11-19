<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Facades\DB;
use App\Models\Category;

final class CategoryRepository
{
    public function getCategoryById(int $id): ?Category
    {
        $stmt = DB::pdo()->prepare(<<<SQL
            SELECT id, title, description
            FROM categories
            WHERE id = ?
            LIMIT 1
        SQL);

        $stmt->execute([$id]);

        $row = $stmt->fetch();

        return $row === false ? null : $this->hydrate($row);
    }

    /**
     * @return list<Category>
     */
    public function getAllCategories(): array
    {
        $stmt = DB::pdo()->query(<<<SQL
            SELECT id, title, description
            FROM categories
            ORDER BY id
        SQL);

        return array_map(
            fn (array $row): Category => $this->hydrate($row),
            $stmt->fetchAll(),
        );
    }

    /**
     * @return list<Category>
     */
    public function getCategoriesWithPosts(): array
    {
        $stmt = DB::pdo()->query(<<<SQL
            SELECT c.id, c.title, c.description
            FROM categories c
            WHERE EXISTS (
                SELECT 1
                FROM category_post cp
                WHERE cp.category_id = c.id
            )
            ORDER BY c.id
        SQL);

        return array_map(
            fn (array $row): Category => $this->hydrate($row),
            $stmt->fetchAll(),
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    private function hydrate(array $row): Category
    {
        return new Category(
            id: (int) $row['id'],
            title: (string) $row['title'],
            description: (string) $row['description'],
        );
    }
}
