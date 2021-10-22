<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use LeoVie\PhpFilesystem\Service\Filesystem;
use PHPUnit\Framework\TestCase;

class FilesystemTest extends TestCase
{
    public function testReadFile(): void
    {
        self::assertSame('file', (new Filesystem())->readFile(__DIR__ . '/../../testdata/file/file.txt'));
    }
}