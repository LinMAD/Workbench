<?php

use App\Config\DbConfig;
use Engine\Core;

// TODO Think about to wrap these to init file to keep index.php more cleaner

/**
 * Handle fatal errors from PHP
 */
function handleFatal() {
    $error = error_get_last();
    if($error['type'] === E_ERROR || $error['type'] === E_USER_ERROR) {
        echo '<pre>';
        $meesage = $error['message'] ?? '';
        echo '<h1>Unexpected error: ' . $meesage . '</h1>';
        var_export($error);
    }
}

register_shutdown_function('handleFatal');

/**
 * Load engine app
 */
$autoloader = require __DIR__ . '/vendor/autoload.php';

try {
    // Create db configuration
    $config = new DbConfig(
        'boozt-test-app-db', // container name
        'test_app',
        'root',
        'my-secret-pw'
    );

    // Initialize engine core

    $engine = new Core($config);

    // TODO Add controller collection
    $engine->getRouter()->addRoute('/', function () use ($engine) {
       echo '<h1>Hello world</h1>';
       /** @var Core $engine */
       $statement = $engine->getDatabaseManager()->prepare('desc mysql.user');
       $statement->execute();
       echo '<pre>';
       var_dump($statement->fetchAll());
    });

    // Execute application
    $engine->run();
} catch(\Throwable $e) {
    echo '<pre>';
    echo '<h1>Exception: ' . $e->getMessage() . '</h1>';
    var_export($e);
}
