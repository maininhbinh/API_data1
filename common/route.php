<?php

use Phroute\Phroute\RouteCollector;

$url = !isset($_GET['url']) ? "/" : $_GET['url'];

$router = new RouteCollector();

$router->get('/', [App\Controllers\ClientesController::class, "get"]);

$router->post('create/client', [App\Controllers\ClientesController::class, "createController"]);

$router->delete('delete/client/{id}', [App\Controllers\ClientesController::class, "deleteControler"]);

$router->get('detail/client/{id}', [App\Controllers\ClientesController::class, "detailController"]);

$router->put('update/client/{id}', [App\Controllers\ClientesController::class, "updateController"]);

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
