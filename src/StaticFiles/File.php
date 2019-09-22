<?php declare(strict_types=1);

namespace App\StaticFiles;

final class File
{
    /**
     * @var string
     */
    public $contents;
    /**
     * @var string
     */
    public $mimeType;

    public function __construct(string $contents, string $mimeType)
    {
        $this->contents = $contents;
        $this->mimeType = $mimeType;
    }
}
