<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Exception;

use Exception;

class InvalidBoundaries extends Exception
{
    private function __construct(int $start, int $end)
    {
        parent::__construct(sprintf('Start boundary %s is greater than end boundary %s.', $start, $end));
    }

    public static function create(int $start, int $end): self
    {
        return new self($start, $end);
    }
}