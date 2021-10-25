<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Service;

use LeoVie\PhpFilesystem\Model\Boundaries;
use Safe\Exceptions\FilesystemException;

class Filesystem
{
    /** @throws FilesystemException */
    public function readFile(string $filepath): string
    {
        return \Safe\file_get_contents($filepath);
    }

    /** @throws FilesystemException */
    public function readFilePart(string $filepath, Boundaries $boundaries): string
    {
        return substr($this->readFile($filepath), $boundaries->start(), $boundaries->end() - $boundaries->start());
    }
}