<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Model;

use LeoVie\PhpFilesystem\Exception\InvalidBoundaries;
use Safe\Exceptions\StringsException;

class Boundaries
{
    private function __construct(private int $start, private int $end)
    {
    }

    /**
     * @throws StringsException
     * @throws InvalidBoundaries
     */
    public static function create(int $start, int $end): self
    {
        if ($start > $end) {
            throw InvalidBoundaries::create($start, $end);
        }

        return new self($start, $end);
    }

    public function start(): int
    {
        return $this->start;
    }

    public function end(): int
    {
        return $this->end;
    }
}