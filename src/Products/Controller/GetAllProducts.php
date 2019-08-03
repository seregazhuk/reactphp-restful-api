<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\Product;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class GetAllProducts
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->storage->getAll()
            ->then(
                function (array $products) {
                    return JsonResponse::ok($this->mapProducts(...$products));
                },
                function (Exception $error) {
                    return JsonResponse::internalServerError($error->getMessage());
                }
            );
    }

    private function mapProducts(Product ...$products): array
    {
        return array_map(
            function (Product $product) {
                return $product->toArray();
            }, $products
        );
    }
}
