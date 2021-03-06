<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\CopyrightEmail;

class CopyrightEmailTest extends QuestionTestCase
{
    protected function getTestClass(): string
    {
        return CopyrightEmail::class;
    }

    protected function getQuestionName(): string
    {
        return 'copyrightEmail';
    }

    protected function getQuestionText(): string
    {
        return 'What is the copyright holder\'s email address?';
    }

    public function testGetDefaultWhenAuthorEmailIsSet(): void
    {
        $question = new CopyrightEmail($this->answers);

        $this->answers->authorEmail = 'samwise@example.com';

        $this->assertSame('samwise@example.com', $question->getDefault());
    }

    /**
     * @dataProvider provideSkipValues
     */
    public function testShouldSkip(bool $choice, bool $expected): void
    {
        $question = new CopyrightEmail($this->answers);

        $this->answers->authorHoldsCopyright = $choice;

        $this->assertSame($expected, $question->shouldSkip());
    }

    /**
     * @return mixed[]
     */
    public function provideSkipValues(): array
    {
        return [
            [
                'choice' => false,
                'expected' => false,
            ],
            [
                'choice' => true,
                'expected' => true,
            ],
        ];
    }
}
