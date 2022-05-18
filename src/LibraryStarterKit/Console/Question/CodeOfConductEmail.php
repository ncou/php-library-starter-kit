<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the email address to which code of conduct issues should be submitted
 */
class CodeOfConductEmail extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;
    use EmailValidatorTool;

    public function getName(): string
    {
        return 'codeOfConductEmail';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What email address should people use to report code of conduct issues?',
            $answers->codeOfConductEmail,
        );

        $this->answers = $answers;
    }

    public function shouldSkip(): bool
    {
        return $this->getAnswers()->codeOfConduct === CodeOfConduct::DEFAULT;
    }
}
