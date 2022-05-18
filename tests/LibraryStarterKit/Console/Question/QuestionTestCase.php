<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Console\Question\StarterKitQuestion;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Question\Question;

abstract class QuestionTestCase extends TestCase
{
    /**
     * @return class-string<Question & StarterKitQuestion>
     */
    abstract protected function getTestClass(): string;

    abstract protected function getQuestionName(): string;

    abstract protected function getQuestionText(): string;

    /**
     * @return mixed
     */
    protected function getQuestionDefault()
    {
        return null;
    }

    public function testGetName(): void
    {
        $questionClass = $this->getTestClass();
        $question = new $questionClass($this->answers);

        $this->assertSame($this->getQuestionName(), $question->getName());
    }

    public function testGetQuestion(): void
    {
        $questionClass = $this->getTestClass();
        $question = new $questionClass($this->answers);

        $this->assertSame($this->getQuestionText(), $question->getQuestion());
    }

    public function testGetAnswers(): void
    {
        $questionClass = $this->getTestClass();
        $question = new $questionClass($this->answers);

        $this->assertSame($this->answers, $question->getAnswers());
    }

    public function testGetDefault(): void
    {
        $questionClass = $this->getTestClass();
        $question = new $questionClass($this->answers);

        $this->assertSame($this->getQuestionDefault(), $question->getDefault());
    }

    public function testGetDefaultWhenAnswerAlreadySet(): void
    {
        $this->answers->{$this->getQuestionName()} = 'foobar';

        $questionClass = $this->getTestClass();
        $question = new $questionClass($this->answers);

        $this->assertSame('foobar', $question->getDefault());
    }
}
