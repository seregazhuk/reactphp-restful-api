<?php declare(strict_types=1);

namespace App\Orders\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class GetAllOrders
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok(['message' => 'GET request to /orders']);
    }
}