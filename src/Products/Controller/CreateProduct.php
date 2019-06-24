<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class CreateProduct
{
    public function __invoke(ServerRequestInterface $request)
    {
        $product = [
            'name' => $request->getParsedBody()['name'],
            'price' => $request->getParsedBody()['price'],
        ];

        return JsonResponse::ok([
            'message' => 'POST request to /products',
            'product' => $product,
        ]);
    }
}
