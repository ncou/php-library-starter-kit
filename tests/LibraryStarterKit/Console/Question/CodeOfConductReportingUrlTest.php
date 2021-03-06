<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\CodeOfConductReportingUrl;

class CodeOfConductReportingUrlTest extends QuestionTestCase
{
    protected function getTestClass(): string
    {
        return CodeOfConductReportingUrl::class;
    }

    protected function getQuestionName(): string
    {
        return 'codeOfConductReportingUrl';
    }

    protected function getQuestionText(): string
    {
        return 'At what URL are your code of conduct reporting guidelines described?';
    }

    /**
     * @dataProvider provideSkipValues
     */
    public function testShouldSkip(?string $choice, bool $expected): void
    {
        $question = new CodeOfConductReportingUrl($this->answers);

        $this->answers->codeOfConduct = $choice;

        $this->assertSame($expected, $question->shouldSkip());
    }

    /**
     * @return mixed[]
     */
    public function provideSkipValues(): array
    {
        return [
            [
                'choice' => null,
                'expected' => true,
            ],
            [
                'choice' => 'Contributor-1.4',
                'expected' => true,
            ],
            [
                'choice' => 'Contributor-2.0',
                'expected' => true,
            ],
            [
                'choice' => 'Citizen-2.3',
                'expected' => false,
            ],
        ];
    }
}
