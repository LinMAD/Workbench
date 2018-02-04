<?php

namespace App;

use App\Models\OrderModel;
use App\View\Orders\OrderViewBuilder;
use Engine\Core;

/** @var Core $engine */
$engine->getRouter()->addRoute('/', function () use ($engine){
    $model = new OrderModel($engine->getDatabaseManager());

    $ordersList = $model->getOrders();

    return (new OrderViewBuilder($ordersList))->buildPage();
});