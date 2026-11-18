<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Facades\View;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

final class HomeController
{
    public function __construct(
        private readonly CategoryRepository $categories,
        private readonly PostRepository $posts,
    ) {
    }

    public function index(): void
    {
        $categories = $this->categories->getCategoriesWithPosts();
        $categoryIds = array_map(
            static fn (Category $category): int => $category->id,
            $categories,
        );
        $latestPosts = $this->posts->getLatestPostsByCategories($categoryIds, 3);

        $sections = array_map(
            static fn (Category $category): array => [
                'category' => $category,
                'posts' => $latestPosts[$category->id] ?? [],
            ],
            $categories,
        );

        View::render('home.tpl', [
            'title' => config('app.name'),
            'sections' => $sections,
        ]);
    }
}
