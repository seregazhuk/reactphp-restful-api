<?php declare(strict_types=1);

namespace App\Orders\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteOrder
{
    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return JsonResponse::ok(['message' => "DELETE request to /products/{$id}"]);
    }
}
