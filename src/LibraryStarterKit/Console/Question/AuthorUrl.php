<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the URL of the library author
 */
class AuthorUrl extends Question implements StarterKitQuestion
{
    use AnswersTool;
    use UrlValidatorTool;

    public function getName(): string
    {
        return 'authorUrl';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What is your website address?',
            $answers->authorUrl,
        );

        $this->answers = $answers;
    }
}
