<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Facades\View;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

final class PageController
{
    public function __construct(
        private readonly CategoryRepository $categories,
        private readonly PostRepository $posts,
    ) {
    }

    public function sections(): void
    {
        $postCounts = $this->posts->getPostCountsByCategory();

        $sections = array_map(
            fn (Category $category): array => [
                'category' => $category,
                'postCount' => $postCounts[$category->id] ?? 0,
            ],
            $this->categories->getAllCategories(),
        );

        View::render('pages/sections.tpl', [
            'title' => 'Все разделы',
            'sections' => $sections,
        ]);
    }

    public function about(): void
    {
        View::render('pages/about.tpl', [
            'title' => 'О блоге',
        ]);
    }
}
