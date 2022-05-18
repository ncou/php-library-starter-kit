<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit;

use Chiron\Dev\LibraryStarterKit\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class FilesystemTest extends TestCase
{
    public function testGetFile(): void
    {
        $filesystem = new Filesystem();
        $file = $filesystem->getFile(__FILE__);

        $this->assertInstanceOf(SplFileInfo::class, $file);
    }
}
