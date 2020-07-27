<?php declare(strict_types=1);

namespace App\Products\Controller\Output;

final class Request
{
    private const URI = 'http://localhost:8000/products/';

    public string $type;

    public string $url;

    public ?array $body;

    public function __construct(string $type, string $url, array $body = null)
    {
        $this->type = $type;
        $this->url = $url;
        $this->body = $body;
    }

    public static function detailedProduct(int $id): self
    {
        return new self('GET', self::URI . $id);
    }

    public static function updateProduct(int $id): self
    {
        return new self('PUT', self::URI . $id);
    }

    public static function listOfProducts(): self
    {
        return new self('GET', self::URI);
    }

    public static function createProduct(): self
    {
        return new self('POST', self::URI, ['name' => 'string', 'price' => 'float']);
    }
}
