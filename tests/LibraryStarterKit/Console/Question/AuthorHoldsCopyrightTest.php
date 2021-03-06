<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorHoldsCopyright;

class AuthorHoldsCopyrightTest extends QuestionTestCase
{
    protected function getTestClass(): string
    {
        return AuthorHoldsCopyright::class;
    }

    protected function getQuestionName(): string
    {
        return 'authorHoldsCopyright';
    }

    protected function getQuestionText(): string
    {
        return 'Are you the copyright holder?';
    }

    /**
     * @inheritDoc
     */
    protected function getQuestionDefault()
    {
        return true;
    }

    public function testGetDefaultWhenAnswerAlreadySet(): void
    {
        $this->answers->authorHoldsCopyright = false;

        $question = new AuthorHoldsCopyright($this->answers);

        $this->assertFalse($question->getDefault());
    }
}
