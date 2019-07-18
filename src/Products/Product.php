<?php declare(strict_types=1);

namespace App\Products;

final class Product
{
    public $id;

    public $name;

    public $price;

    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }
}
