<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the name of the committee responsible for handling code of conduct issues
 */
class CodeOfConductCommittee extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;

    public function getName(): string
    {
        return 'codeOfConductCommittee';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What is the name of your group or committee who oversees code of conduct issues?',
            $answers->codeOfConductCommittee,
        );

        $this->answers = $answers;
    }

    public function getValidator(): callable
    {
        return fn (?string $data): ?string => $data;
    }

    public function shouldSkip(): bool
    {
        // This question is only applicable for the Citizen-2.3 code of conduct.
        return $this->getAnswers()->codeOfConduct !== CodeOfConduct::CHOICE_IDENTIFIER_MAP[4];
    }
}
