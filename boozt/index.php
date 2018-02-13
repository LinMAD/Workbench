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
    $config = new DbConfig('boozt-test-app-db', 'test_app','root','my-secret-pw');
    $engine = new Core($config);

    // Load all controllers
    if ($handle = opendir(__DIR__ . '/src/Controller')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry !== '.' && $entry !== '..') {
                require_once __DIR__ . "/src/Controller/$entry";
            }
        }
        closedir($handle);
    }

    // Execute application
    $engine::run();
} catch(\Throwable $e) {
    echo '<pre>';
    echo '<h1>Exception: ' . $e->getMessage() . '</h1>';
    var_export($e);
}
