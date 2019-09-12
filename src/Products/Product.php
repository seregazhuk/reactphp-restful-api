<?php declare(strict_types=1);

namespace App\Products;

final class Product
{
    public $id;

    public $name;

    public $price;

    public $image;

    public function __construct(int $id, string $name, float $price, ?string $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
    }
}
