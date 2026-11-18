<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Facades\View;
use App\Repositories\PostRepository;

final class PostController
{
    public function __construct(
        private readonly PostRepository $posts,
    ) {
    }

    public function show(int $id): void
    {
        $this->posts->incrementViews($id);
        $post = $this->posts->getPostById($id);

        if ($post === null) {
            throw new NotFoundException(sprintf('Post %d not found.', $id));
        }

        $similarPosts = array_slice($this->posts->getSimilarPosts($post), 0, 3);

        View::render('post.tpl', [
            'title' => $post->title,
            'post' => $post,
            'similarPosts' => $similarPosts,
        ]);
    }
}
