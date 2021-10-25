<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Tests\Unit\Exception;

use LeoVie\PhpFilesystem\Exception\InvalidBoundaries;
use PHPUnit\Framework\TestCase;

class InvalidBoundariesTest extends TestCase
{
    public function testGetMessage(): void
    {
        self::assertSame(
            'Start boundary 10 is greater than end boundary 8.',
            InvalidBoundaries::create(10, 8)->getMessage(),
        );
    }
}