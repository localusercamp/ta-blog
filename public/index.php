<?php

declare(strict_types=1);

use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Exceptions\NotFoundException;
use App\Facades\DB;
use App\Facades\View;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

require_once __DIR__ . '/../vendor/autoload.php';

View::register(new View(
    template_dir: config('paths.views'),
    compile_dir: config('paths.compile'),
    cache_dir: config('paths.cache'),
));

DB::register(new DB(
    host: config('db.host'),
    port: config('db.port'),
    database: config('db.database'),
    username: config('db.username'),
    password: config('db.password'),
));

$categoryRepository = new CategoryRepository();
$postRepository = new PostRepository();

$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');

if ($path === 'index.php') {
    $path = '';
}

try {
    if ($path === '') {
        (new HomeController($categoryRepository, $postRepository))->index();
    } elseif (preg_match('#^category/(\d+)$#', $path, $matches) === 1) {
        (new CategoryController($categoryRepository, $postRepository))->show((int) $matches[1]);
    } elseif (preg_match('#^post/(\d+)$#', $path, $matches) === 1) {
        (new PostController($postRepository))->show((int) $matches[1]);
    } else {
        throw new NotFoundException('Page not found.');
    }
} catch (NotFoundException) {
    http_response_code(404);
    View::render('404.tpl', ['title' => 'Страница не найдена']);
}
