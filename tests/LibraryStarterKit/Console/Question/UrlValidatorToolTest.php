<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\UrlValidatorTool;
use Chiron\Dev\LibraryStarterKit\Exception\InvalidConsoleInput;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;

class UrlValidatorToolTest extends TestCase
{
    /**
     * @dataProvider provideNullableValues
     */
    public function testValidatorThrowsExceptionForEmptyValuesWhenQuestionIsNotOptional(?string $value): void
    {
        $question = new class () {
            use UrlValidatorTool;

            public function __construct()
            {
                $this->isOptional = false;
            }
        };

        $validator = $question->getValidator();

        $this->expectException(InvalidConsoleInput::class);
        $this->expectExceptionMessage('You must enter a valid URL, beginning with "http://" or "https://".');

        $validator($value);
    }

    /**
     * @dataProvider provideNullableValues
     */
    public function testValidatorReturnsNullWhenQuestionIsOptional(?string $value): void
    {
        $question = new class () {
            use UrlValidatorTool;
        };

        $validator = $question->getValidator();

        $this->assertNull($validator($value));
    }

    /**
     * @return mixed[]
     */
    public function provideNullableValues(): array
    {
        return [
            ['value' => null],
            ['value' => ''],
            ['value' => '    '],
        ];
    }

    public function testValidatorReturnsValueWhenValid(): void
    {
        $question = new class () {
            use UrlValidatorTool;
        };

        $validator = $question->getValidator();

        $this->assertSame('https://example.com', $validator('https://example.com'));
    }

    public function testValidatorThrowsExceptionWhenNotValid(): void
    {
        $question = new class () {
            use UrlValidatorTool;
        };

        $validator = $question->getValidator();

        $this->expectException(InvalidConsoleInput::class);
        $this->expectExceptionMessage('You must enter a valid URL, beginning with "http://" or "https://".');

        $validator('ftp://example.com');
    }
}
