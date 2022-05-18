<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Task\Builder;

use Chiron\Dev\LibraryStarterKit\Task\Builder;

/**
 * Replaces this project's FUNDING.yml file with an empty one for the new project
 */
class UpdateFunding extends Builder
{
    public function build(): void
    {
        $this->getConsole()->section('Updating .github/FUNDING.yml');

        $changelog = $this->getEnvironment()->getTwigEnvironment()->render(
            'FUNDING.yml.twig',
            $this->getAnswers()->getArrayCopy(),
        );

        $this->getEnvironment()->getFilesystem()->dumpFile(
            $this->getEnvironment()->path('.github/FUNDING.yml'),
            $changelog,
        );
    }
}
