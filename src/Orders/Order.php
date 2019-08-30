<?php declare(strict_types=1);

namespace App\Orders;

final class Order
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $productId;
    /**
     * @var int
     */
    public $quantity;

    public function __construct(int $id, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
