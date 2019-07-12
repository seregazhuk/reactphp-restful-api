<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\Storage;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteProduct
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return $this->storage->delete((int)$id)
            ->then(
                function () {
                    return JsonResponse::noContent();
                },
                function (\Exception $error) {
                    return JsonResponse::internalServerError($error->getMessage());
                }
            );
    }
}
