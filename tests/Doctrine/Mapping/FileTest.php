<?php

namespace Leapt\CoreBundle\Tests\Doctrine\Mapping;

use Leapt\CoreBundle\Doctrine\Mapping\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testFilename(): void
    {
        $file = new File();

        self::assertNull($file->filename);
        $file->filename = 'filename';
        self::assertSame('filename', $file->filename);
    }

    public function testPath(): void
    {
        $file = new File();

        self::assertNull($file->path);
        $file->path = 'path';
        self::assertSame('path', $file->path);
    }

    public function testFlysystemAdapter(): void
    {
        $file = new File();

        self::assertNull($file->flysystemAdapter);
        $file->flysystemAdapter = 'flysystemAdapter';
        self::assertSame('flysystemAdapter', $file->flysystemAdapter);
    }

    public function testMappedBy(): void
    {
        $file = new File();

        self::assertNull($file->mappedBy);
        $file->mappedBy = 'mappedBy';
        self::assertSame('mappedBy', $file->mappedBy);
    }

    public function testNameCallback(): void
    {
        $file = new File();

        self::assertNull($file->nameCallback);
        $file->nameCallback = 'nameCallback';
        self::assertSame('nameCallback', $file->nameCallback);
    }

    public function testPathCallback(): void
    {
        $file = new File();

        self::assertNull($file->pathCallback);
        $file->pathCallback = 'pathCallback';
        self::assertSame('pathCallback', $file->pathCallback);
    }
}