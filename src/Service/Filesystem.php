<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Service;

use Safe\Exceptions\FilesystemException;

class Filesystem
{
    /** @throws FilesystemException */
    public function readFile(string $filepath): string
    {
        return \Safe\file_get_contents($filepath);
    }
}