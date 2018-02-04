<?php

use Engine\Core;

/**
 * Load engine app
 */
$autoloader = require __DIR__ . '/vendor/autoload.php';


$engine = new Core();

var_dump($engine->test());