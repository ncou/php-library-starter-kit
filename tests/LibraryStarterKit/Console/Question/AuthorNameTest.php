<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorName;

class AuthorNameTest extends QuestionTestCase
{
    protected function getTestClass(): string
    {
        return AuthorName::class;
    }

    protected function getQuestionName(): string
    {
        return 'authorName';
    }

    protected function getQuestionText(): string
    {
        return 'What is your name?';
    }
}
