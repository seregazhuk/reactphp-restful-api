<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateProduct
{
    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return JsonResponse::ok(['message' => "GET request to /products/{$id}"]);
    }
}
