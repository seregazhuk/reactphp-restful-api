<?php declare(strict_types=1);

namespace App\Products;

use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

final class Storage
{
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(string $name, float $price, ?string $image): PromiseInterface
    {
        return $this->connection
            ->query(
                'INSERT INTO products (name, price, image) VALUES (?, ?, ?)',
                [$name, $price, $image]
            )
            ->then(
                function (QueryResult $result) use ($name, $price, $image) {
                    return new Product($result->insertId, $name, $price, $image);
                }
            );
    }

    public function getById(int $id): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, name, price, image FROM products WHERE id = ?', [$id])
            ->then(
                function (QueryResult $result) {
                    if (empty($result->resultRows)) {
                        throw new ProductNotFound();
                    }

                    return $this->mapProduct($result->resultRows[0]);
                }
            );
    }

    public function getAll(): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, name, price, image FROM products')
            ->then(function (QueryResult $result) {
                return array_map(function ($row) {
                    return $this->mapProduct($row);
                }, $result->resultRows);
            });
    }

    public function delete(int $id): PromiseInterface
    {
        return $this->getById($id)
            ->then(function (Product $product) {
                $this->connection->query('DELETE FROM products WHERE id = ?', [$product->id]);
            });
    }

    public function update(int $id, string $name, float $price): PromiseInterface
    {
        return $this->getById($id)
            ->then(function (Product $product) use ($name, $price) {
                return $this->connection->query(
                    'UPDATE products SET name = ?, price = ? WHERE id =?',
                    [$name, $price, $product->id]
                );
            });
    }

    private function mapProduct(array $row): Product
    {
        return new Product(
            (int)$row['id'],
            $row['name'],
            (float)$row['price'],
            $row['image']
        );
    }
}
