<?php declare(strict_types=1);

namespace App\Core;

use React\Http\Response;

final class JsonResponse extends Response
{
    public function __construct(int $statusCode, $data = null)
    {
        $data = $data ? json_encode($data) : null;

        parent::__construct($statusCode, ['Content-type' => 'application/json'], $data);
    }

    public static function ok($data): self
    {
        return new self(200, $data);
    }

    public static function internalServerError(string $reason): self
    {
        return new self(500, ['message' => $reason]);
    }

    public static function notFound(): self
    {
        return new self(404);
    }
}
