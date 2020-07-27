<?php

declare(strict_types=1);

namespace App\Orders\Controller\CreateOrder;

use App\Core\JsonResponse;
use App\Orders\Controller\Output\Order as Output;
use App\Orders\Controller\Output\Request;
use App\Orders\Order;
use App\Orders\Storage as Orders;
use App\Products\Product;
use App\Products\ProductNotFound;
use App\Products\Storage as Products;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class Controller
{
    private Orders $orders;

    private Products $products;

    public function __construct(Orders $orders, Products $products)
    {
        $this->orders = $orders;
        $this->products = $products;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $input = new Input($request);
        $input->validate();

        return $this->products
            ->getById($input->productId())
            ->then(
                function (Product $product) use ($input) {
                    return $this->orders
                        ->create($input->productId(), $input->quantity());
                }
            )
            ->then(
                function (Order $order) {
                    $response = [
                        'order' => Output::fromEntity(
                            $order,
                            Request::listOrders()
                        ),
                    ];
                    return JsonResponse::created($response);
                }
            )
            ->otherwise(
                function (ProductNotFound $error) {
                    return JsonResponse::badRequest('Product not found.');
                }
            )
            ->otherwise(
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}
