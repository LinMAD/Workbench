<?php

use App\Config\DbConfig;
use Engine\Core;

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
    // TODO add pdo ext to php in docker file and add percona
    // Create db configuration
//    $config = new DbConfig(
//        'localhost',
//        'test_app',
//        'system_test_app',
//        'someSecurePass'
//    );

    $engine = new Core();
    $container = $engine->getContainer();

    //$db = $container->getService(Core::SERV_DB);
} catch(\Throwable $e) {
    echo '<pre>';
    echo '<h1>Exception: ' . $e->getMessage() . '</h1>';
    var_export($e);
}