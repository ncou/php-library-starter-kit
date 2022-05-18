<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Asks whether the author is the same person as the copyright holder
 */
class AuthorHoldsCopyright extends ConfirmationQuestion implements StarterKitQuestion
{
    use AnswersTool;

    public function getName(): string
    {
        return 'authorHoldsCopyright';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'Are you the copyright holder?',
            $answers->authorHoldsCopyright,
        );

        $this->answers = $answers;
    }
}
