<?php declare(strict_types=1);

namespace App\Products\Controller\Output;

use App\Products\Product as ProductEntity;

final class Product
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $price;

    /**
     * @var Request
     */
    public $request;

    private function __construct(int $id, string $name, float $price, Request $request)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->request = $request;
    }

    public static function fromEntity(ProductEntity $product, Request $request): self
    {
        return new self(
            $product->id, $product->name, $product->price, $request
        );
    }
}
