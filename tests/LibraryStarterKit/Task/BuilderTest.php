<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task;

use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;

class BuilderTest extends TestCase
{
    private Builder $builder;

    /** @var SymfonyStyle|MockInterface */
    private SymfonyStyle $console;

    /** @var Setup|MockInterface */
    private Setup $setup;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setup = $this->mockery(Setup::class);
        $this->console = $this->mockery(SymfonyStyle::class);
        $build = new Build($this->setup, $this->console, $this->answers);

        $this->builder = new class ($build) extends Builder {
            public function build(): void
            {
            }
        };
    }

    public function testGetAnswers(): void
    {
        $this->assertSame($this->answers, $this->builder->getAnswers());
    }

    public function testGetEnvironment(): void
    {
        $this->assertSame($this->setup, $this->builder->getEnvironment());
    }

    public function testGetConsole(): void
    {
        $this->assertSame($this->console, $this->builder->getConsole());
    }

    public function testStreamProcessOutput(): void
    {
        $streamProcessOutput = $this->builder->streamProcessOutput();

        $this->console->expects()->write('writes a message to output');

        $streamProcessOutput('foo', 'writes a message to output');
    }
}
