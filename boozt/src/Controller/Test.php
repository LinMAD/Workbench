<?php

namespace App;

use Engine\Core;

/** @var Core $engine */
//TODO investigate why apache return 404
$engine->getRouter()->addRoute('test', function () {
    echo '<h1>Form test</h1>';
});
