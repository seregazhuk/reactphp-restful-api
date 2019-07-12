<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\Product;
use App\Products\ProductNotFound;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class GetProductById
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return $this->storage
            ->getById((int)$id)
            ->then(
                function (Product $product) {
                    return JsonResponse::ok($product->toArray());
                },
                function (ProductNotFound $error) {
                    return JsonResponse::notFound();
                },
                function (Exception $error) {
                    return JsonResponse::internalServerError($error->getMessage());
                }
            );
    }
}
