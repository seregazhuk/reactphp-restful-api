<?php declare(strict_types=1);

namespace App\Orders\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class CreateOrder
{
    public function __invoke(ServerRequestInterface $request)
    {
        $order = [
            'productId' => $request->getParsedBody()['productId'],
            'quantity' => $request->getParsedBody()['quantity'],
        ];

        return JsonResponse::ok([
            'message' => 'POST request to /orders',
            'order' => $order,
        ]);
    }
}
