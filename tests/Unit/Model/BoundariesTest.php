<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Tests\Unit\Model;

use LeoVie\PhpFilesystem\Exception\InvalidBoundaries;
use LeoVie\PhpFilesystem\Model\Boundaries;
use PHPUnit\Framework\TestCase;

class BoundariesTest extends TestCase
{
    /** @dataProvider startProvider */
    public function testStart(int $start): void
    {
        self::assertSame($start, Boundaries::create($start, $start + 1)->start());
    }

    public function startProvider(): array
    {
        return [
            [10],
            [100],
            [991],
        ];
    }

    /** @dataProvider endProvider */
    public function testEnd(int $end): void
    {
        self::assertSame($end, Boundaries::create($end - 1, $end)->end());
    }

    public function endProvider(): array
    {
        return [
            [10],
            [100],
            [991],
        ];
    }

    /** @dataProvider createThrowsProvider */
    public function testCreateThrows(int $start, int $end): void
    {
        self::expectException(InvalidBoundaries::class);

        Boundaries::create($start, $end);
    }

    public function createThrowsProvider(): array
    {
        return [
            [
                'start' => 10,
                'end' => 9
            ],
            [
                'start' => 999,
                'end' => 0
            ],
        ];
    }

    /** @dataProvider createThrowsNotProvider */
    public function testCreateThrowsNot(int $start, int $end): void
    {
        Boundaries::create($start, $end);

        self::addToAssertionCount(1);
    }

    public function createThrowsNotProvider(): array
    {
        return [
            [
                'start' => 10,
                'end' => 10
            ],
            [
                'start' => 0,
                'end' => 999
            ],
            [
                'start' => 10,
                'end' => 11
            ],
        ];
    }
}