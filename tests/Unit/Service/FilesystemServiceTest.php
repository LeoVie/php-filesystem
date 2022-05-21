<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Tests\Unit\Service;

use LeoVie\PhpFilesystem\Exception\DirectoryPathExistsAsFile;
use LeoVie\PhpFilesystem\Model\Boundaries;
use LeoVie\PhpFilesystem\Service\FilesystemService;
use PHPUnit\Framework\TestCase;

class FilesystemServiceTest extends TestCase
{
    private const TESTDATA_DIR = __DIR__ . '/../../testdata/file';
    private const EXISTING_FILE = self::TESTDATA_DIR . '/file.txt';
    private const NOT_EXISTING_FILE = self::TESTDATA_DIR . '/not_existing_file.txt';
    private const FILE_TO_WRITE = self::TESTDATA_DIR . '/to_write.txt';

    public function testReadFile(): void
    {
        self::assertSame('file', (new FilesystemService())->readFile(self::EXISTING_FILE));
    }

    /** @dataProvider readPartProvider */
    public function testReadPart(string $expected, string $fileContent, Boundaries $boundaries): void
    {
        $fileSystem = $this->createPartialMock(FilesystemService::class, ['readFile']);
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

    public function testWriteFile(): void
    {
        if (file_exists(self::FILE_TO_WRITE)) {
            unlink(self::FILE_TO_WRITE);
        }

        self::assertFileDoesNotExist(self::FILE_TO_WRITE);

        $fileContent = 'this is content';
        (new FilesystemService())->writeFile(self::FILE_TO_WRITE, $fileContent);

        self::assertFileExists(self::FILE_TO_WRITE);
        self::assertSame($fileContent, file_get_contents(self::FILE_TO_WRITE));

        if (file_exists(self::FILE_TO_WRITE)) {
            unlink(self::FILE_TO_WRITE);
        }
    }

    /** @dataProvider fileExistsProvider */
    public function testFileExists(bool $expected, string $filepath): void
    {
        self::assertSame($expected, (new FilesystemService())->fileExists($filepath));
    }

    public function fileExistsProvider(): array
    {
        return [
            'existing' => [
                'expected' => true,
                'filepath' => self::EXISTING_FILE,
            ],
            'not existing' => [
                'expected' => false,
                'filepath' => self::NOT_EXISTING_FILE,
            ],
        ];
    }

    public function testMakeDirRecursiveThrows(): void
    {
        self::expectException(DirectoryPathExistsAsFile::class);
        self::expectExceptionMessage('Directory path "' . self::TESTDATA_DIR . '/file' . '" exists as file.');

        (new FilesystemService())->makeDirRecursive(self::TESTDATA_DIR, 'file');
    }

    public function testMakeDirRecursive(): void
    {
        if (is_dir(self::TESTDATA_DIR . '/directory/subdirectory')) {
            \Safe\rmdir(self::TESTDATA_DIR . '/directory/subdirectory');
        }
        if (is_dir(self::TESTDATA_DIR . '/directory')) {
            \Safe\rmdir(self::TESTDATA_DIR . '/directory');
        }
        self::assertDirectoryDoesNotExist(self::TESTDATA_DIR . '/directory');

        (new FilesystemService())->makeDirRecursive(self::TESTDATA_DIR, 'directory/subdirectory');
        self::assertDirectoryExists(self::TESTDATA_DIR . '/directory/subdirectory');
    }
}