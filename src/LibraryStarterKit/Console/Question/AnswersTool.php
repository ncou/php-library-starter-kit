<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;

trait AnswersTool
{
    private Answers $answers;

    public function getAnswers(): Answers
    {
        return $this->answers;
    }
}
