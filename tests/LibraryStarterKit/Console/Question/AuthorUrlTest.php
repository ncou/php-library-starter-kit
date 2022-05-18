<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorUrl;

class AuthorUrlTest extends QuestionTestCase
{
    protected function getTestClass(): string
    {
        return AuthorUrl::class;
    }

    protected function getQuestionName(): string
    {
        return 'authorUrl';
    }

    protected function getQuestionText(): string
    {
        return 'What is your website address?';
    }
}
