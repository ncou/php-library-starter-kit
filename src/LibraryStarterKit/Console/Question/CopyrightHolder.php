<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the name of the copyright holder
 */
class CopyrightHolder extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;

    public function getName(): string
    {
        return 'copyrightHolder';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct('Who is the copyright holder?');

        $this->answers = $answers;
    }

    /**
     * @inheritDoc
     */
    public function getDefault()
    {
        return $this->getAnswers()->copyrightHolder ?? $this->getAnswers()->authorName;
    }

    public function shouldSkip(): bool
    {
        return $this->getAnswers()->authorHoldsCopyright === true;
    }
}
