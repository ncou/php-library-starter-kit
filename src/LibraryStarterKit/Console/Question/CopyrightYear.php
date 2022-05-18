<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Chiron\Dev\LibraryStarterKit\Exception\InvalidConsoleInput;
use Symfony\Component\Console\Question\Question;

use function date;
use function preg_match;
use function trim;

/**
 * Asks for the initial copyright year
 */
class CopyrightYear extends Question implements StarterKitQuestion
{
    use AnswersTool;

    private const VALID_PATTERN = '/^\d{4}$/';

    public function getName(): string
    {
        return 'copyrightYear';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct('What is the copyright year?');

        $this->answers = $answers;
    }

    /**
     * @inheritDoc
     */
    public function getDefault()
    {
        return $this->getAnswers()->copyrightYear ?? date('Y');
    }

    public function getValidator(): callable
    {
        return function (?string $data): string {
            if (preg_match(self::VALID_PATTERN, trim((string) $data)) === 1) {
                return (string) $data;
            }

            throw new InvalidConsoleInput('You must enter a valid, 4-digit year.');
        };
    }
}
