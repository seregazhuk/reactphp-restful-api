<?php

declare(strict_types=1);

namespace App\Core;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use Respect\Validation\Exceptions\NestedValidationException;
use Throwable;

use function React\Promise\resolve;

final class ErrorHandler
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return resolve($next($request))
                ->then(
                    function (Response $response) {
                        return $response;
                    },
                    function (Throwable $error) {
                        return $this->handleThrowable($error);
                    }
                );
        } catch (NestedValidationException $exception) {
            return JsonResponse::badRequest(...$exception->getMessages());
        } catch (Throwable $error) {
            return $this->handleThrowable($error);
        }
    }

    private function handleThrowable(Throwable $error): Response
    {
        echo "Error: ", $error->getTraceAsString(), PHP_EOL;

        return JsonResponse::internalServerError($error->getMessage());
    }
}
