<?php declare(strict_types=1);

namespace App\Orders\Controller\Output;

final class Request
{
    private const URI = 'http://localhost:8000/orders';
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $url;
    /**
     * @var array
     */
    public $body;

    private function __construct(string $type, string $url, array $body = null)
    {
        $this->type = $type;
        $this->url = $url;
        $this->body = $body;
    }

    public static function detailedOrder(int $id): self
    {
        return new self('GET', self::URI . '/' . $id);
    }

    public static function listOrders(): self
    {
        return new self('GET', self::URI);
    }

    public static function deleteOrder(int $id): self
    {
        return new self('DELETE', self::URI . '/' . $id);
    }

    public static function createOrder(): self
    {
        return new self('POST', self::URI, ['productId' => 'integer', 'quantity' => 'integer']);
    }
}
