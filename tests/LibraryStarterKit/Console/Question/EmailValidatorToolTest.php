<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\EmailValidatorTool;
use Chiron\Dev\LibraryStarterKit\Exception\InvalidConsoleInput;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;

class EmailValidatorToolTest extends TestCase
{
    /**
     * @dataProvider provideNullableValues
     */
    public function testValidatorThrowsExceptionForEmptyValuesWhenQuestionIsNotOptional(?string $value): void
    {
        $question = new class () {
            use EmailValidatorTool;

            public function __construct()
            {
                $this->isOptional = false;
            }
        };

        $validator = $question->getValidator();

        $this->expectException(InvalidConsoleInput::class);
        $this->expectExceptionMessage('You must enter a valid email address.');

        $validator($value);
    }

    /**
     * @dataProvider provideNullableValues
     */
    public function testValidatorReturnsNullWhenQuestionIsOptional(?string $value): void
    {
        $question = new class () {
            use EmailValidatorTool;
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
            use EmailValidatorTool;
        };

        $validator = $question->getValidator();

        $this->assertSame('jane@example.com', $validator('jane@example.com'));
    }

    public function testValidatorThrowsExceptionWhenNotValid(): void
    {
        $question = new class () {
            use EmailValidatorTool;
        };

        $validator = $question->getValidator();

        $this->expectException(InvalidConsoleInput::class);
        $this->expectExceptionMessage('You must enter a valid email address.');

        $validator('not-a-valid-address');
    }
}
