<?php declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\Controller\Output\Product as Output;
use App\Products\Controller\Output\Request;
use App\Products\Product;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class CreateProduct
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $input = new Input($request);
        $input->validate();

        return $this->storage->create($input->name(), $input->price())->then(
                function (Product $product) {
                    $response = [
                        'product' => Output::fromEntity(
                            $product, Request::detailedProduct($product->id)
                        ),
                    ];
                    return JsonResponse::ok($response);
                }, function (Exception $exception) {
                return JsonResponse::internalServerError($exception->getMessage());
            }
            );
    }
}
