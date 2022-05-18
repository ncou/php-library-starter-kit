<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Task\Builder;

use Chiron\Dev\LibraryStarterKit\Task\Builder;

/**
 * Updates the project's CHANGELOG using the CHANGELOG template
 */
class UpdateChangelog extends Builder
{
    public function build(): void
    {
        $this->getConsole()->section('Updating CHANGELOG.md');

        $changelog = $this->getEnvironment()->getTwigEnvironment()->render(
            'CHANGELOG.md.twig',
            $this->getAnswers()->getArrayCopy(),
        );

        $this->getEnvironment()->getFilesystem()->dumpFile(
            $this->getEnvironment()->path('CHANGELOG.md'),
            $changelog,
        );
    }
}
