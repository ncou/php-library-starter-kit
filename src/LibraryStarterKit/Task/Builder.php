<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Task;

use Chiron\Dev\LibraryStarterKit\Answers;
use Chiron\Dev\LibraryStarterKit\Setup;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Represents a builder that uses user responses to build some part of a library
 */
abstract class Builder
{
    private Build $buildTask;

    public function __construct(Build $buildTask)
    {
        $this->buildTask = $buildTask;
    }

    /**
     * Executes the build action for this particular builder
     */
    abstract public function build(): void;

    public function getAnswers(): Answers
    {
        return $this->buildTask->getAnswers();
    }

    public function getEnvironment(): Setup
    {
        return $this->buildTask->getSetup();
    }

    public function getConsole(): SymfonyStyle
    {
        return $this->buildTask->getConsole();
    }

    /**
     * Returns a callback that may be used to stream process output to stdout
     *
     * @return callable(string, string): void
     */
    public function streamProcessOutput(): callable
    {
        return function (string $_type, string $buffer): void {
            $this->getConsole()->write($buffer);
        };
    }
}
