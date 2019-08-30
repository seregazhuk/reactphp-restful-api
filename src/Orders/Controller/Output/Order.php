<?php declare(strict_types=1);

namespace App\Orders\Controller\Output;

use App\Orders\Order as OrderEntity;

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
    /**
     * @var Request
     */
    public $request;

    private function __construct(int $id, int $productId, int $quantity, Request $request)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->request = $request;
    }

    public static function fromEntity(OrderEntity $order, Request $request): self
    {
        return new self(
            $order->id,
            $order->productId,
            $order->quantity,
            $request
        );
    }
}
