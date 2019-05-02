<?php

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

require 'vendor/autoload.php';

$loop = Factory::create();

$server = new Server(function (ServerRequestInterface $request) {
    return new Response(
        200, ['Content-Type' => 'application/json'], json_encode(['message' => 'Hello'])
    );
});

$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);
$server->listen($socket);

echo 'Listening on ' . str_replace('tcp', 'http', $socket->getAddress()) . PHP_EOL;
$loop->run();
