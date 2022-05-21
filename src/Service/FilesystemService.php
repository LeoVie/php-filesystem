<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Service;

use LeoVie\PhpFilesystem\Exception\DirectoryPathExistsAsFile;
use LeoVie\PhpFilesystem\Model\Boundaries;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\StringsException;

class FilesystemService implements Filesystem
{
    public function fileExists(string $filepath): bool
    {
        return file_exists($filepath);
    }

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

    public function writeFile(string $filepath, string $content): int
    {
        return \Safe\file_put_contents($filepath, $content);
    }

    /**
     * @throws FilesystemException
     * @throws StringsException
     * @throws DirectoryPathExistsAsFile
     */
    public function makeDirRecursive(string $parentPath, string $path): void
    {
        $directories = explode('/', $path);

        if ($directories[0] === '') {
            return;
        }

        $firstDirectory = array_shift($directories);
        $firstDirectoryPath = $parentPath . '/' . $firstDirectory;

        if ($this->fileExists($firstDirectoryPath) && !is_dir($firstDirectoryPath)) {
            throw DirectoryPathExistsAsFile::create($firstDirectoryPath);
        }

        if (!is_dir($firstDirectoryPath)) {
            \Safe\mkdir($firstDirectoryPath);
        }

        $this->makeDirRecursive(
            $firstDirectoryPath,
            join('/', $directories)
        );
    }
}