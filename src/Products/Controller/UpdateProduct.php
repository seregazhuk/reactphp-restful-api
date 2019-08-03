<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\ProductNotFound;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateProduct
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $id)
    {
        $name = $request->getParsedBody()['name'];
        $price = $request->getParsedBody()['price'];

        return $this->storage->update((int)$id, $name, (float)$price)
            ->then(
                function () {
                    return JsonResponse::noContent();
                }
            )
            ->otherwise(function (ProductNotFound $error) {
                return JsonResponse::notFound();
            })
            ->otherwise(function (Exception $error) {
                return JsonResponse::internalServerError($error->getMessage());
            });
        }
}
