<?php

 

require_once(dirname(__FILE__) ."/Utils/Router.php");

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ .'/Pages/index.php';
});
$router->addRoute('/category', function () {
    require __DIR__ .'/Pages/category.php';
});
$router->addRoute('/product', function () {
    require __DIR__ .'/Pages/product.php';
});

$router->addRoute('/create', function () {
    require __DIR__ .'/Pages/create.php';
});

$router->dispatch();
?>