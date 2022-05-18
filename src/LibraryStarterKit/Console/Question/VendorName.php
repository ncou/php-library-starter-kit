<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Chiron\Dev\LibraryStarterKit\Exception\InvalidConsoleInput;
use Symfony\Component\Console\Question\Question;

use function preg_match;
use function strtolower;

/**
 * Asks for the vendor name to use for this package
 */
class VendorName extends Question implements StarterKitQuestion
{
    use AnswersTool;

    private const VALID_PATTERN = '/^[a-z0-9]([_.-]?[a-z0-9]+)*$/';

    public function getName(): string
    {
        return 'vendorName';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct('What is your package vendor name?');

        $this->answers = $answers;
    }

    /**
     * @inheritDoc
     */
    public function getDefault()
    {
        return $this->getAnswers()->vendorName ?? $this->getAnswers()->githubUsername;
    }

    public function getValidator(): callable
    {
        return function (?string $data): string {
            $data = strtolower((string) $data);

            if (preg_match(self::VALID_PATTERN, $data)) {
                return $data;
            }

            throw new InvalidConsoleInput(
                'You must enter a valid vendor name.',
            );
        };
    }
}
