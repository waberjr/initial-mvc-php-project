<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

use \CoffeeCode\Router\Router;

$router = new Router(url());
$router->namespace("Source\Controller");

//Posts
$router->get("/", "WebController:home");

//ERROR ROUTES
$router->get("/ops/{errcode}", "WebController:error");
$router->group(null);

$router->dispatch();

if($router->error()){
    $router->redirect("/ops/{$router->error()}");
}

ob_end_flush();