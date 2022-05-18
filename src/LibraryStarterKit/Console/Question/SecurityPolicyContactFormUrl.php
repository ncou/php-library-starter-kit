<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Symfony\Component\Console\Question\Question;

/**
 * Asks for a URL that where security researchers may submit reports
 */
class SecurityPolicyContactFormUrl extends Question implements SkippableQuestion, StarterKitQuestion
{
    use AnswersTool;
    use UrlValidatorTool;

    public function getName(): string
    {
        return 'securityPolicyContactFormUrl';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct(
            'At what URL should researchers submit vulnerability reports?',
            $answers->securityPolicyContactFormUrl,
        );

        $this->answers = $answers;
    }

    public function shouldSkip(): bool
    {
        return $this->getAnswers()->securityPolicy === false;
    }
}
