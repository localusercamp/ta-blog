<?php

declare(strict_types=1);

use App\Facades\DB;
use App\Facades\View;

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

View::render('index.tpl', [
    'title'    => config('app.name'),
    'debug'    => config('app.debug'),
]);
