<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console;

use Chiron\Dev\LibraryStarterKit\Console\InstallQuestions;
use Chiron\Dev\LibraryStarterKit\Console\Question\StarterKitQuestion;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Question\Question;

class InstallQuestionsTest extends TestCase
{
    public function testGetQuestions(): void
    {
        $questions = new InstallQuestions();
        $receivedQuestions = $questions->getQuestions($this->answers);

        $this->assertContainsOnlyInstancesOf(Question::class, $receivedQuestions);
        $this->assertContainsOnlyInstancesOf(StarterKitQuestion::class, $receivedQuestions);
        $this->assertCount(23, $receivedQuestions);
    }
}
