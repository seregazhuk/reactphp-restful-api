<?php declare(strict_types=1);

namespace App\Authentication;

final class User
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;

    public function __construct(int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
}
