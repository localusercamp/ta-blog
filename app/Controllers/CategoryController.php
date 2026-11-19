<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Facades\View;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

final class CategoryController
{
    private const POSTS_PER_PAGE = 6;

    public function __construct(
        private readonly CategoryRepository $categories,
        private readonly PostRepository $posts,
    ) {
    }

    public function show(int $id): void
    {
        $category = $this->categories->getCategoryById($id);

        if ($category === null) {
            throw new NotFoundException(sprintf('Category %d not found.', $id));
        }

        $sort = ($_GET['sort'] ?? null) === 'views' ? 'views' : 'date';
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $total = $this->posts->getPostCountByCategory($category->id);
        $lastPage = max(1, (int) ceil($total / self::POSTS_PER_PAGE));
        $page = min($page, $lastPage);

        $posts = $this->posts->getPostsByCategory(
            categoryId: $category->id,
            sortByViews: $sort === 'views',
            limit: self::POSTS_PER_PAGE,
            offset: ($page - 1) * self::POSTS_PER_PAGE,
        );

        View::render('pages/category.tpl', [
            'title' => $category->title,
            'category' => $category,
            'posts' => $posts,
            'sort' => $sort,
            'page' => $page,
            'previousPage' => $page - 1,
            'nextPage' => $page + 1,
            'lastPage' => $lastPage,
            'total' => $total,
        ]);
    }
}
