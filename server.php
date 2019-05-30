<?php

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

require 'vendor/autoload.php';

$loop = Factory::create();

$dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $routes) {
    $routes->get('/products', function (ServerRequestInterface $request) {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'GET request to /products'])
        );
    });

    $routes->post('/products', function (ServerRequestInterface $request) {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'POST request to /products'])
        );
    });
});

$server = new Server(function (ServerRequestInterface $request) use ($dispatcher) {
    $routeInfo = $dispatcher->dispatch(
        $request->getMethod(), $request->getUri()->getPath()
    );

    switch ($routeInfo[0]) {
        case \FastRoute\Dispatcher::NOT_FOUND:
            return new Response(404, ['Content-Type' => 'text/plain'], 'Not found');
        case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            return new Response(405, ['Content-Type' => 'text/plain', 'Method not allowed']);
        case \FastRoute\Dispatcher::FOUND:
            return $routeInfo[1]($request);

        throw new LogicException('Something went wrong with routing');
    }
});

$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp', 'http', $socket->getAddress()) . PHP_EOL;
$loop->run();
