<?php

use App\Core\ErrorHandler;
use App\Core\JsonRequestDecoder;
use App\Core\Router;
use App\Orders\Controller\CreateOrder;
use App\Orders\Controller\DeleteOrder;
use App\Orders\Controller\GetAllOrders;
use App\Orders\Controller\GetOrderById;
use App\Products\Controller\CreateProduct;
use App\Products\Controller\DeleteProduct;
use App\Products\Controller\GetAllProducts;
use App\Products\Controller\GetProductById;
use App\Products\Controller\UpdateProduct;
use Dotenv\Dotenv;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use React\EventLoop\Factory;
use React\Http\Server;
use React\MySQL\QueryResult;

require 'vendor/autoload.php';

$loop = Factory::create();

$env = Dotenv::create(__DIR__);
$env->load();

$factory = new \React\MySQL\Factory($loop);
$uri = getenv('DB_LOGIN') . ':' . getenv('DB_PASS') . '@' . getenv('DB_HOST') . '/' . getenv('DB_NAME');
$connection = $factory->createLazyConnection($uri);

$connection->query('SHOW TABLES')
    ->then(function (QueryResult $result) {
        print_r($result->resultRows);
    });

$routes = new RouteCollector(new Std(), new GroupCountBased());
$routes->get('/products', new GetAllProducts());
$routes->post('/products', new CreateProduct());
$routes->get('/products/{id:\d+}', new GetProductById());
$routes->put('/products/{id:\d+}', new UpdateProduct());
$routes->delete('/products/{id:\d+}', new DeleteProduct());

$routes->get('/orders', new GetAllOrders());
$routes->post('/orders', new CreateOrder());
$routes->get('/orders/{id:\d+}', new GetOrderById());
$routes->delete('/orders/{id:\d+}', new DeleteOrder());

$server = new Server([new ErrorHandler(), new JsonRequestDecoder(), new Router($routes)]);

$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);
$server->listen($socket);

$server->on('error', function (Throwable $error) {
    echo 'Error: ' . $error->getMessage() . PHP_EOL;
});

echo 'Listening on ' . str_replace('tcp', 'http', $socket->getAddress()) . PHP_EOL;
$loop->run();
