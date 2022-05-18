<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for the email address to which researchers should submit vulnerability reports
 */
class SecurityPolicyContactEmail extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;
    use EmailValidatorTool;

    public function getName(): string
    {
        return 'securityPolicyContactEmail';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'What email address should researchers use to submit vulnerability reports?',
            $answers->securityPolicyContactEmail,
        );

        $this->answers = $answers;
    }

    public function shouldSkip(): bool
    {
        return $this->getAnswers()->securityPolicy === false;
    }
}
