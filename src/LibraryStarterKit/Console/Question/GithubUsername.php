<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the GitHub username or org name of the project owner
 */
class GithubUsername extends Question implements StarterKitQuestion
{
    use AnswersTool;

    public function getName(): string
    {
        return 'githubUsername';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What is the GitHub username or org name for your package?',
            $answers->githubUsername,
        );

        $this->answers = $answers;
    }
}
