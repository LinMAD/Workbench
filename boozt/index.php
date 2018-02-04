<?php

use Engine\Core;

/**
 * Load engine app
 */
$autoloader = require __DIR__ . '/vendor/autoload.php';


$engine = new Core();

$appContainer = $engine->test();
$serviceFoo = $appContainer->getService('foo');
var_dump($serviceFoo);