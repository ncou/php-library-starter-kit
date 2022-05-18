<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit;

use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Wraps the Symfony Filesystem class to provide additional file operations
 */
class Filesystem extends SymfonyFilesystem
{
    /**
     * Returns an instance of a file
     */
    public function getFile(string $path): SplFileInfo
    {
        return new SplFileInfo($path, '', '');
    }
}
