<?php

declare(strict_types=1);

use App\Core\Database;
use App\Facades\View;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';
// $view =  View();
$dbStatus = 'MySQL недоступен.';

View::register();

try {
    $pdo = Database::connect($config['db']);
    $pdo->query('SELECT 1');

    $tables = $pdo->query("SHOW TABLES LIKE 'posts'")->fetchAll();
    $dbStatus = $tables === []
        ? 'MySQL доступен, схема ещё не применена.'
        : 'MySQL доступен, схема применена.';
} catch (Throwable $exception) {
    if ($config['app']['debug']) {
        $dbStatus .= ' ' . $exception->getMessage();
    }
}

$view->render('index.tpl', [
    'title' => 'Каркас проекта',
    'dbStatus' => $dbStatus,
    'debug' => $config['app']['debug'],
]);
