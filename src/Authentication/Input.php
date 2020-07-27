<?php

declare(strict_types=1);

namespace App\Authentication;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

final class Input
{
    private ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function validate(): void
    {
        $emailValidator = Validator::key(
            'email',
            Validator::allOf(
                Validator::email(),
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('email');

        $password = Validator::key(
            'password',


            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('password');

        Validator::allOf($emailValidator, $password)->assert($this->request->getParsedBody());
    }

    public function email(): string
    {
        return $this->request->getParsedBody()['email'];
    }

    public function hashedPassword(): string
    {
        return password_hash($this->password(), PASSWORD_BCRYPT);
    }

    public function password(): string
    {
        return $this->request->getParsedBody()['password'];
    }
}
