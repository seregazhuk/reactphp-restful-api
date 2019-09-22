<?php declare(strict_types=1);

namespace App\StaticFiles;

use Narrowspark\MimeType\MimeTypeFileExtensionGuesser;
use React\Filesystem\FilesystemInterface;
use React\Filesystem\Node\FileInterface;
use React\Promise\PromiseInterface;

final class Webroot
{
    private $filesystem;

    private $projectRoot;

    public function __construct(FilesystemInterface $filesystem, string $projectRoot)
    {
        $this->filesystem = $filesystem;
        $this->projectRoot = $projectRoot;
    }

    public function file(string $path): PromiseInterface
    {
        $file = $this->filesystem->file($this->projectRoot . $path);

        return $file
            ->exists()
            ->then(
                function () use ($file) {
                    return $this->readFile($file);
                },
                function () {
                    throw new FileNotFound();
                }
            );
    }

    private function readFile(FileInterface $file): PromiseInterface
    {
        return $file->getContents()
            ->then(function ($contents) use ($file) {
                $mimeType = MimeTypeFileExtensionGuesser::guess($file->getPath());
                return new File($contents, $mimeType);
            });
    }
}
