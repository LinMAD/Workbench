<?php

use Engine\Core;

/** @var Core $engine */
$engine->getRouter()->addRoute('/', function () use ($engine){
    $model = new \App\Models\OrderModel($engine->getDatabaseManager());

    $ordersList = $model->getOrders();
    var_dump($ordersList);
});