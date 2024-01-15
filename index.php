<?php

session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\framework\DisplayError;
use Illuminate\framework\Application;
use Illuminate\framework\Debug;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();

$error = new DisplayError();
$error->setErrorHandler();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_CONNECTION'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config);

require_once './routes/api.php';
require_once './routes/web.php';

$app->run();
