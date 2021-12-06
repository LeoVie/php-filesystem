<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Service;

use LeoVie\PhpFilesystem\Model\Boundaries;
use Safe\Exceptions\FilesystemException;

interface Filesystem
{
    public function fileExists(string $filepath): bool;

    /** @throws FilesystemException */
    public function readFile(string $filepath): string;

    /** @throws FilesystemException */
    public function readFilePart(string $filepath, Boundaries $boundaries): string;

    public function writeFile(string $filepath, string $content): int;
}