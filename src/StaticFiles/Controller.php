<?php declare(strict_types=1);

namespace App\StaticFiles;

use App\Core\JsonResponse;
use Exception;
use Narrowspark\MimeType\MimeTypeFileExtensionGuesser;
use Psr\Http\Message\ServerRequestInterface;
use React\Filesystem\FilesystemInterface;
use React\Filesystem\Node\FileInterface;
use React\Http\Response;
use React\Promise\PromiseInterface;

final class Controller
{
    private $filesystem;

    private $projectRoot;

    public function __construct(FilesystemInterface $filesystem, string $projectRoot)
    {
        $this->filesystem = $filesystem;
        $this->projectRoot = $projectRoot;
    }

    public function __invoke(ServerRequestInterface $request): PromiseInterface
    {
        $path = $this->projectRoot . $request->getUri()->getPath();
        $file = $this->filesystem->file($path);

        return $file
            ->exists()
            ->then(
                function () use ($file) {
                    return $this->returnResponseWithFile($file);
                },
                function () {
                    return JsonResponse::notFound();
                }
            );
    }

    private function returnResponseWithFile(FileInterface $file): PromiseInterface
    {
        return $file
            ->getContents()
            ->then(
                function ($contents) use ($file) {
                    return new Response(
                        200,
                        ['Content-Type' =>  MimeTypeFileExtensionGuesser::guess($file->getPath())],
                        $contents
                    );
                },
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                });

    }
}
