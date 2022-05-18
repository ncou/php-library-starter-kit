<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\GithubUsername;

class GithubUsernameTest extends QuestionTestCase
{
    protected function getTestClass(): string
    {
        return GithubUsername::class;
    }

    protected function getQuestionName(): string
    {
        return 'githubUsername';
    }

    protected function getQuestionText(): string
    {
        return 'What is the GitHub username or org name for your package?';
    }
}
