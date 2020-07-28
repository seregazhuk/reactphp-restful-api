<?php declare(strict_types=1);

namespace App\Authentication;

use App\Core\JsonResponse;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

final class SignInController
{
    private Authenticator $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $input = new Input($request);
        $input->validate();

        return $this->authenticator->authenticate($input->email(), $input->password())
            ->then(
                function ($jwt) {
                    return JsonResponse::ok(['token' => $jwt]);
                }
            )
            ->otherwise(
                function (BadCredentials $exception) {
                    return JsonResponse::unauthorized();
                }
            )
            ->otherwise(
                function (UserNotFound $exception) {
                    return JsonResponse::unauthorized();
                }
            );
    }
}
