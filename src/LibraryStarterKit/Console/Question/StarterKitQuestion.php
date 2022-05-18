<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;

interface StarterKitQuestion
{
    public function getAnswers(): Answers;

    public function getName(): string;
}
