<?php declare(strict_types=1);

namespace App\Authentication;

use App\Core\JsonResponse;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;

final class ProtectedRoute
{
    /**
     * @var string
     */
    private $jwtKey;
    /**
     * @var callable
     */
    private $middleware;

    public function __construct(string $jwtKey, callable $middleware)
    {
        $this->jwtKey = $jwtKey;
        $this->middleware = $middleware;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($this->authorize($request)) {
            return call_user_func($this->middleware, $request);
        }

        return JsonResponse::unauthorized();
    }

    private function authorize(ServerRequestInterface $request): bool
    {
        $header = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        if (empty($token)) {
            return false;
        }

        return JWT::decode($token, $this->jwtKey, ['HS256']) !== null;
    }
}
