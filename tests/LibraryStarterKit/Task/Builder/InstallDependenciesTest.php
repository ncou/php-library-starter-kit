<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task\Builder;

use Hamcrest\Type\IsCallable;
use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder\InstallDependencies;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

use const DIRECTORY_SEPARATOR;

class InstallDependenciesTest extends TestCase
{
    public function testBuild(): void
    {
        $console = $this->mockery(SymfonyStyle::class);
        $console->expects()->section('Installing dependencies');

        $filesystem = $this->mockery(Filesystem::class);
        $filesystem->expects()->remove([
            '/path/to/app' . DIRECTORY_SEPARATOR . 'composer.lock',
            '/path/to/app' . DIRECTORY_SEPARATOR . 'vendor',
        ]);

        $process = $this->mockery(Process::class);
        $process->expects()->mustRun(new IsCallable());

        $environment = $this->mockery(Setup::class, [
            'getAppPath' => '/path/to/app',
            'getFileSystem' => $filesystem,
        ]);

        $environment
            ->shouldReceive('path')
            ->andReturnUsing(fn (string $path): string => '/path/to/app' . DIRECTORY_SEPARATOR . $path);

        $environment
            ->expects()
            ->getProcess([
                'composer',
                'update',
                '--no-interaction',
                '--ansi',
                '--no-progress',
            ])
            ->andReturn($process);

        /** @var Build & MockInterface $build */
        $build = $this->mockery(Build::class, [
            'getSetup' => $environment,
            'getConsole' => $console,
        ]);

        $builder = new InstallDependencies($build);

        $builder->build();
    }
}
