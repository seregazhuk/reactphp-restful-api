<?php declare(strict_types=1);

namespace App\Orders\Controller;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

final class GetOrderById
{
    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => "GET request to /orders/{$id}"])
        );
    }
}
