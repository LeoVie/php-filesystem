<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Tests\Unit\Service;

use LeoVie\PhpFilesystem\Model\Boundaries;
use LeoVie\PhpFilesystem\Service\Filesystem;
use PHPUnit\Framework\TestCase;

class FilesystemTest extends TestCase
{
    public function testReadFile(): void
    {
        self::assertSame('file', (new Filesystem())->readFile(__DIR__ . '/../../testdata/file/file.txt'));
    }

    /** @dataProvider readPartProvider */
    public function testReadPart(string $expected, string $fileContent, Boundaries $boundaries): void
    {
        $fileSystem = $this->createPartialMock(Filesystem::class, ['readFile']);
        $fileSystem->method('readFile')->willReturn($fileContent);

        self::assertSame($expected, $fileSystem->readFilePart('', $boundaries));
    }

    public function readPartProvider(): array
    {
        return [
            'empty file' => [
                'expected' => '',
                'fileContent' => '',
                'boundaries' => Boundaries::create(5, 60),
            ],
            'startPos = endPos' => [
                'expected' => '',
                'fileContent' => 'this is the file content',
                'boundaries' => Boundaries::create(5, 5),
            ],
            'endPos > startPos' => [
                'expected' => 'is th',
                'fileContent' => 'this is the file content',
                'boundaries' => Boundaries::create(5, 10),
            ],
        ];
    }
}