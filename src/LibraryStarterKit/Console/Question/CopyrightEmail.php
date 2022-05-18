<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the email address of the copyright holder
 */
class CopyrightEmail extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;
    use EmailValidatorTool;

    public function getName(): string
    {
        return 'copyrightEmail';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct('What is the copyright holder\'s email address?');

        $this->answers = $answers;
    }

    /**
     * @inheritDoc
     */
    public function getDefault()
    {
        return $this->getAnswers()->copyrightEmail ?? $this->getAnswers()->authorEmail;
    }

    public function shouldSkip(): bool
    {
        return $this->getAnswers()->authorHoldsCopyright === true;
    }
}
