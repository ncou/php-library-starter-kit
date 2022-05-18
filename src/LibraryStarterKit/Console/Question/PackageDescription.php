<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for a brief description of the library
 */
class PackageDescription extends Question implements StarterKitQuestion
{
    use AnswersTool;

    public function getName(): string
    {
        return 'packageDescription';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'Enter a brief description of your library',
            $answers->packageDescription,
        );

        $this->answers = $answers;
    }

    public function getValidator(): callable
    {
        return fn (?string $data): ?string => $data;
    }
}
