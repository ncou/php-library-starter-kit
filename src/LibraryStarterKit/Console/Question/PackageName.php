<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Answers;
use Chiron\Dev\LibraryStarterKit\Exception\InvalidConsoleInput;
use Symfony\Component\Console\Question\Question;

use function preg_match;
use function strpos;
use function strtolower;
use function trim;

/**
 * Asks for the package name (i.e., the name to use for this package on Packagist.org)
 */
class PackageName extends Question implements StarterKitQuestion
{
    use AnswersTool;

    private const VALID_PATTERN = '/^[a-z0-9]([_.-]?[a-z0-9]+)*\/[a-z0-9](([_.]?|-{0,2})[a-z0-9]+)*$/';

    public function getName(): string
    {
        return 'packageName';
    }

    public function __construct(Answers $answers)
    {
        parent::__construct('What is your package name?');

        $this->answers = $answers;
    }

    /**
     * @inheritDoc
     */
    public function getDefault()
    {
        if ($this->getAnswers()->packageName !== null) {
            return $this->getAnswers()->packageName;
        }

        $packageName = (string) $this->getAnswers()->vendorName
            . '/'
            . (string) $this->getAnswers()->projectName;

        if (trim($packageName) === '/') {
            return null;
        }

        return $packageName;
    }

    public function getValidator(): callable
    {
        return function (?string $data): string {
            $vendorPrefix = '';
            if ($this->getAnswers()->vendorName !== null) {
                $vendorPrefix = strtolower((string) $this->getAnswers()->vendorName) . '/';
            }

            $data = strtolower((string) $data);

            if ($vendorPrefix !== '' && strpos($data, $vendorPrefix) !== 0) {
                $data = $vendorPrefix . $data;
            }

            if (preg_match(self::VALID_PATTERN, $data)) {
                return $data;
            }

            throw new InvalidConsoleInput(
                'You must enter a valid package name.',
            );
        };
    }
}
