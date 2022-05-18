<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Task\Builder;

use Chiron\Dev\LibraryStarterKit\Task\Builder;

/**
 * Installs project dependencies after building a new library
 */
class InstallDependencies extends Builder
{
    public function build(): void
    {
        $this->getConsole()->section('Installing dependencies');

        // Remove lockfiles and vendor directories to start fresh.
        $this->getEnvironment()->getFilesystem()->remove([
            $this->getEnvironment()->path('composer.lock'),
            $this->getEnvironment()->path('vendor'),
        ]);

        $process = $this->getEnvironment()->getProcess([
            'composer',
            'update',
            '--no-interaction',
            '--ansi',
            '--no-progress',
        ]);

        $process->mustRun($this->streamProcessOutput());
    }
}
