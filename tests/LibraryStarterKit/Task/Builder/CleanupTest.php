<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task\Builder;

use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder\Cleanup;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;

use const DIRECTORY_SEPARATOR;

class CleanupTest extends TestCase
{
    public function testBuild(): void
    {
        $console = $this->mockery(SymfonyStyle::class);

        $console->expects()->section('Cleaning up...');
        $console->expects()->text(
            '<comment>  - Deleted \'/path/to/app/resources' . DIRECTORY_SEPARATOR . 'templates\'.</comment>',
        );
        $console->expects()->text(
            '<comment>  - Deleted \'/path/to/app/src' . DIRECTORY_SEPARATOR . 'LibraryStarterKit\'.</comment>',
        );
        $console->expects()->text(
            '<comment>  - Deleted \'/path/to/app/tests' . DIRECTORY_SEPARATOR . 'LibraryStarterKit\'.</comment>',
        );
        $console->expects()->text(
            '<comment>  - Deleted \'/path/to/app/.git\'.</comment>',
        );
        $console->expects()->text(
            '<comment>  - Deleted \'/path/to/app/.starter-kit-answers\'.</comment>',
        );

        $filesystem = $this->mockery(Filesystem::class);
        $filesystem->expects()->remove('/path/to/app/resources' . DIRECTORY_SEPARATOR . 'templates');
        $filesystem->expects()->remove('/path/to/app/src' . DIRECTORY_SEPARATOR . 'LibraryStarterKit');
        $filesystem->expects()->remove('/path/to/app/tests' . DIRECTORY_SEPARATOR . 'LibraryStarterKit');
        $filesystem->expects()->remove('/path/to/app/.git');
        $filesystem->expects()->remove('/path/to/app/.starter-kit-answers');

        $environment = $this->mockery(Setup::class, [
            'getFilesystem' => $filesystem,
        ]);

        $environment
            ->shouldReceive('path')
            ->andReturnUsing(fn (string $path): string => '/path/to/app/' . $path);

        /** @var Build & MockInterface $build */
        $build = $this->mockery(Build::class, [
            'getSetup' => $environment,
            'getConsole' => $console,
        ]);

        $builder = new Cleanup($build);

        $builder->build();
    }
}
