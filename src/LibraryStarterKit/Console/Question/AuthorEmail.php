<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the email address of the library author
 */
class AuthorEmail extends Question implements StarterKitQuestion
{
    use AnswersTool;
    use EmailValidatorTool;

    public function getName(): string
    {
        return 'authorEmail';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What is your email address?',
            $answers->authorEmail,
        );

        $this->answers = $answers;

        // Require the author's email address.
        $this->isOptional = false;
    }
}
