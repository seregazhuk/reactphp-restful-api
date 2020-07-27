<?php

declare(strict_types=1);

namespace App\StaticFiles;

final class File
{
    public string $contents;
    public string $mimeType;

    public function __construct(string $contents, string $mimeType)
    {
        $this->contents = $contents;
        $this->mimeType = $mimeType;
    }
}
