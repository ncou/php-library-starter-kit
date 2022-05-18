<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Task\Builder;

use Chiron\Dev\LibraryStarterKit\Task\Builder;

/**
 * Fixes any style issues we might encounter (e.g., use statements sorting, etc.)
 */
class FixStyle extends Builder
{
    public function build(): void
    {
        $this->getConsole()->section('Fixing style issues...');

        $this
            ->getEnvironment()
            ->getProcess(['composer', 'dev:lint:fix'])
            ->mustRun($this->streamProcessOutput());
    }
}
