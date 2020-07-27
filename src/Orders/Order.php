<?php declare(strict_types=1);

namespace App\Orders;

final class Order
{
    public int $id;

    public int $productId;

    public int $quantity;

    public function __construct(int $id, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
