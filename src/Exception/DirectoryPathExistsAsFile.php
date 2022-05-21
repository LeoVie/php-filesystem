<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Exception;

use Exception;
use Safe\Exceptions\StringsException;

class DirectoryPathExistsAsFile extends Exception
{
    private function __construct(string $path)
    {
        parent::__construct(sprintf('Directory path "%s" exists as file.', $path));
    }

    public static function create(string $path): self
    {
        return new self($path);
    }
}