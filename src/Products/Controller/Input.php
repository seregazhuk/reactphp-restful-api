<?php declare(strict_types=1);

namespace App\Products\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

final class Input
{
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function validate(): void
    {
        $nameValidator = Validator::key('name', Validator::allOf(Validator::notBlank(), Validator::stringType()))->setName('name');
        $priceValidator = Validator::key('price', Validator::allOf(Validator::numeric(), Validator::positive(), Validator::notBlank()))->setName('price');

        Validator::allOf($nameValidator, $priceValidator)->assert($this->request->getParsedBody());
    }

    public function price(): float
    {
        return (float)$this->request->getParsedBody()['price'];
    }

    public function name(): string
    {
        return $this->request->getParsedBody()['name'];
    }
}
