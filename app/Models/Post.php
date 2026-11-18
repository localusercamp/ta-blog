<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeImmutable;
use InvalidArgumentException;

final readonly class Post
{
    /**
     * @param list<Category> $categories
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $content,
        public ?string $image,
        public int $views,
        public DateTimeImmutable $publishedAt,
        public array $categories = [],
    ) {
        $this->assertCategories($categories);
    }

    /**
     * @param array<array-key, mixed> $categories
     */
    private function assertCategories(array $categories): void
    {
        foreach ($categories as $category) {
            if (!$category instanceof Category) {
                throw new InvalidArgumentException(sprintf(
                    'Post categories must contain only %s, %s given.',
                    Category::class,
                    get_debug_type($category),
                ));
            }
        }
    }
}
