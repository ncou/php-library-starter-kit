<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the URL of the copyright holder
 */
class CopyrightUrl extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;
    use UrlValidatorTool;

    public function getName(): string
    {
        return 'copyrightUrl';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct('What is the copyright holder\'s website address?');

        $this->answers = $answers;
    }

    /**
     * @inheritDoc
     */
    public function getDefault()
    {
        return $this->getAnswers()->copyrightUrl ?? $this->getAnswers()->authorUrl;
    }

    public function shouldSkip(): bool
    {
        return $this->getAnswers()->authorHoldsCopyright === true;
    }
}
