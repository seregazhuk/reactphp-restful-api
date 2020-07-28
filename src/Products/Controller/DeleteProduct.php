<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\Controller\Output\Request;
use App\Products\ProductNotFound;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteProduct
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return $this->storage->delete((int)$id)
            ->then(
                function () {
                    $response = [
                        'request' => Request::createProduct(),
                    ];
                    return JsonResponse::ok($response);
                }
            )
            ->otherwise(
                function (ProductNotFound $error) {
                    return JsonResponse::notFound();
                }
            );
    }
}
