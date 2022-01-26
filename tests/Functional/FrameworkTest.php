<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Tests\Functional;

use LeoVie\PhpFilesystem\Service\Filesystem;
use PHPUnit\Framework\TestCase;

class FrameworkTest extends TestCase
{
    public function testServiceWiring(): void
    {
        $kernel = new TestingKernel('test', true);
        $kernel->boot();
        $filesystem = $kernel->getContainer()->get(Filesystem::class);

        self::assertInstanceOf(Filesystem::class, $filesystem);
    }
}