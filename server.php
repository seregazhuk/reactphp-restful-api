<?php

use App\Products\Controller\CreateProduct;
use App\Products\Controller\GetAllProducts;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use React\EventLoop\Factory;
use React\Http\Server;

require 'vendor/autoload.php';

$loop = Factory::create();

$routes = new RouteCollector(new Std(), new GroupCountBased());
$routes->get('/products', new GetAllProducts());
$routes->post('/products', new CreateProduct());
$routes->get('/products/{id:\d+}', new \App\Products\Controller\GetProductById());
$routes->put('/products/{id:\d+}', new \App\Products\Controller\UpdateProduct());
$routes->delete('/products/{id:\d+}', new \App\Products\Controller\DeleteProduct());

$server = new Server(new \App\Router($routes));

$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp', 'http', $socket->getAddress()) . PHP_EOL;
$loop->run();
