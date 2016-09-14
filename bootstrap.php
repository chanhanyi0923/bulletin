<?php

require_once __DIR__ . '/vendor/autoload.php';

define('ROOT_DIR', __DIR__);

foreach (json_decode(file_get_contents(ROOT_DIR.'/config.json')) as $key => $value) {
	define($key, $value);
}

$config = [
    'settings' => [
        'displayErrorDetails' => DEV_MODE
    ]
];

$app = new \Slim\App($config);

$container = $app->getContainer();
$container['DoctrineEntityManager'] = new \app\Database;
$container['LeaguePlates'] = function () {
    return new \League\Plates\Engine(ROOT_DIR . '/views');
};

(new \app\Route)();

$app->run();
