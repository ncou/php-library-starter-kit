<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the name of the library author
 */
class AuthorName extends Question implements StarterKitQuestion
{
    use AnswersTool;

    public function getName(): string
    {
        return 'authorName';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What is your name?',
            $answers->authorName,
        );

        $this->answers = $answers;
    }
}
