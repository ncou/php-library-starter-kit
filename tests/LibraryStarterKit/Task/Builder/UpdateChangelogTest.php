<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task\Builder;

use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder\UpdateChangelog;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment as TwigEnvironment;

class UpdateChangelogTest extends TestCase
{
    public function testBuild(): void
    {
        $console = $this->mockery(SymfonyStyle::class);
        $console->expects()->section('Updating CHANGELOG.md');

        $filesystem = $this->mockery(Filesystem::class);
        $filesystem
            ->shouldReceive('dumpFile')
            ->once()
            ->withArgs(function (string $path, string $contents) {
                $this->assertSame('/path/to/app/CHANGELOG.md', $path);
                $this->assertSame('changelogContents', $contents);

                return true;
            });

        $twig = $this->mockery(TwigEnvironment::class);

        $twig
            ->expects()
            ->render('CHANGELOG.md.twig', $this->answers->getArrayCopy())
            ->andReturn('changelogContents');

        $environment = $this->mockery(Setup::class, [
            'getAppPath' => '/path/to/app',
            'getFilesystem' => $filesystem,
            'getTwigEnvironment' => $twig,
        ]);

        $environment
            ->shouldReceive('path')
            ->andReturnUsing(fn (string $path): string => '/path/to/app/' . $path);

        /** @var Build & MockInterface $build */
        $build = $this->mockery(Build::class, [
            'getAnswers' => $this->answers,
            'getConsole' => $console,
            'getSetup' => $environment,
        ]);

        $builder = new UpdateChangelog($build);

        $builder->build();
    }
}
