<?php declare(strict_types=1);

namespace App\Products;

use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

final class Storage
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(string $name, float $price): PromiseInterface
    {
        return $this->connection
            ->query('INSERT INTO products (name, price) VALUES (?, ?)', [$name, $price])
            ->then(function (QueryResult $result) use ($name, $price) {
                return new Product($result->insertId, $name, $price);
            });
    }
}
