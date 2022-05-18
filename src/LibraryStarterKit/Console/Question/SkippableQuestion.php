<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

interface SkippableQuestion
{
    public function shouldSkip(): bool;
}
