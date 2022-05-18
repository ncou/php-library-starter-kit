<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Task\Builder;

use Chiron\Dev\LibraryStarterKit\Task\Builder;

/**
 * Runs all tests for the newly-created project
 */
class RunTests extends Builder
{
    public function build(): void
    {
        $this->getConsole()->section('Running project tests...');

        $this
            ->getEnvironment()
            ->getProcess(['composer', 'dev:test:all'])
            ->mustRun($this->streamProcessOutput());
    }
}
