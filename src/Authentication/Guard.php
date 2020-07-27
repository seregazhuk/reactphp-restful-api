<?php declare(strict_types=1);

namespace App\Authentication;

final class Guard
{
    private string $jwtKey;

    public function __construct(string $jwtKey)
    {
        $this->jwtKey = $jwtKey;
    }

    public function protect(callable $middleware): ProtectedRoute
    {
        return new ProtectedRoute($this->jwtKey, $middleware);
    }
}
