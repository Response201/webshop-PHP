<?php
// globala initieringar !
require_once(dirname(__FILE__) ."/Utils/Router.php");
require_once("vendor/autoload.php");



$router = new Router();


$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



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