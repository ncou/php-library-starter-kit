<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task\Builder;

use ArrayObject;
use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder\RenameTemplates;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use function implode;

use const DIRECTORY_SEPARATOR;

class RenameTemplatesTest extends TestCase
{
    public function testBuild(): void
    {
        $pathParts = [
            'path',
            'to',
            'a',
            'filename.template',
        ];

        $expectedPathParts = [
            'path',
            'to',
            'a',
            'filename',
        ];

        $path = implode(DIRECTORY_SEPARATOR, $pathParts);
        $expectedPath = implode(DIRECTORY_SEPARATOR, $expectedPathParts);

        $console = $this->mockery(SymfonyStyle::class);
        $console->expects()->section('Renaming template files');
        $console->expects()->text("<comment>  - Renaming '{$path}' to '{$expectedPath}'.</comment>");

        $filesystem = $this->mockery(Filesystem::class);
        $filesystem->expects()->rename($path, $expectedPath);

        $file1 = $this->mockery(SplFileInfo::class, [
            'getRealPath' => $path,
        ]);

        $finder = $this->mockery(Finder::class, [
            'getIterator' => new ArrayObject([$file1]),
        ]);

        $finder->expects()->ignoreDotFiles(false)->andReturnSelf();
        $finder->expects()->exclude(['build', 'vendor'])->andReturnSelf();
        $finder->expects()->in('/path/to/app')->andReturnSelf();
        $finder->expects()->name('*.template')->andReturnSelf();
        $finder->expects()->name('.*.template');

        $environment = $this->mockery(Setup::class, [
            'getAppPath' => '/path/to/app',
            'getFileSystem' => $filesystem,
            'getFinder' => $finder,
        ]);

        /** @var Build & MockInterface $build */
        $build = $this->mockery(Build::class, [
            'getSetup' => $environment,
            'getConsole' => $console,
        ]);

        $renameTemplates = new RenameTemplates($build);

        $renameTemplates->build();
    }
}
