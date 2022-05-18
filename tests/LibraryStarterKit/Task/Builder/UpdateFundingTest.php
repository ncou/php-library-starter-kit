<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task\Builder;

use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder\UpdateFunding;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment as TwigEnvironment;

class UpdateFundingTest extends TestCase
{
    public function testBuild(): void
    {
        $console = $this->mockery(SymfonyStyle::class);
        $console->expects()->section('Updating .github/FUNDING.yml');

        $filesystem = $this->mockery(Filesystem::class);
        $filesystem
            ->shouldReceive('dumpFile')
            ->once()
            ->withArgs(function (string $path, string $contents) {
                $this->assertSame('/path/to/app/.github/FUNDING.yml', $path);
                $this->assertSame('fundingContents', $contents);

                return true;
            });

        $twig = $this->mockery(TwigEnvironment::class);

        $twig
            ->expects()
            ->render('FUNDING.yml.twig', $this->answers->getArrayCopy())
            ->andReturn('fundingContents');

        $environment = $this->mockery(Setup::class, [
            'getAppPath' => '/path/to/app',
            'getFilesystem' => $filesystem,
            'getTwigEnvironment' => $twig,
        ]);

        $environment
            ->shouldReceive('path')
            ->andReturnUsing(fn (string $path): string => '/path/to/app/' . $path);

        /** @var Build & MockInterface $task */
        $task = $this->mockery(Build::class, [
            'getAnswers' => $this->answers,
            'getConsole' => $console,
            'getSetup' => $environment,
        ]);

        $builder = new UpdateFunding($task);

        $builder->build();
    }
}
