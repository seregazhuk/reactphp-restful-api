<?php declare(strict_types=1);

namespace App\Authentication;

use App\Core\JsonResponse;
use Exception;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;

final class SignInController
{
    /**
     * @var \App\Authentication\Storage
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

    public function __invoke(ServerRequestInterface $request)
    {
        $input = new Input($request);
        $input->validate();

        return $this->storage->findByEmail($input->email())
            ->then(
                function (User $user) use ($input) {
                    if (password_verify($input->password(), $user->password)) {
                        $payload = [
                            'userId' => $user->id,
                            'email' => $user->email
                        ];
                        return JsonResponse::ok(['token' => JWT::encode($payload, $this->jwtKey)]);
                    }

                    return JsonResponse::unauthorized();
                }
            )
            ->otherwise(
                function (UserNotFound $exception) {
                    return JsonResponse::unauthorized();
                }
            )
            ->otherwise(
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}
