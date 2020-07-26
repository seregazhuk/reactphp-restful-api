<?php declare(strict_types=1);

namespace App\Authentication;

use Firebase\JWT\JWT;
use React\Promise\PromiseInterface;

final class Authenticator
{
    private const TOKEN_EXPIRES_IN = 60 * 60; // 1 hour

    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var string
     */
    private $jwtKey;

    public function __construct(Storage $storage, string $jwtKey)
    {
        $this->storage = $storage;
        $this->jwtKey = $jwtKey;
    }

    public function authenticate(string $email, string $password): PromiseInterface
    {
        return $this->storage->findByEmail($email)
            ->then(
                function (User $user) use ($password) {
                    if (!password_verify($password, $user->password)) {
                        throw new BadCredentials();
                    }

                    $payload = [
                        'userId' => $user->id,
                        'email' => $user->email,
                        'exp' => time() + self::TOKEN_EXPIRES_IN,
                    ];
                    return JWT::encode($payload, $this->jwtKey);
                }
            );
    }
}
