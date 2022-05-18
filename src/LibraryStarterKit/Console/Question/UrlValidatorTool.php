<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console\Question;

use Chiron\Dev\LibraryStarterKit\Exception\InvalidConsoleInput;

use function filter_var;
use function strpos;
use function trim;

use const FILTER_VALIDATE_URL;

/**
 * Common URL validation functionality
 */
trait UrlValidatorTool
{
    private bool $isOptional = true;

    public function getValidator(): callable
    {
        return function (?string $data): ?string {
            if ($this->isOptional && ($data === null || trim($data) === '')) {
                return null;
            }

            if (
                filter_var((string) $data, FILTER_VALIDATE_URL)
                && strpos((string) $data, 'http') === 0
            ) {
                return $data;
            }

            throw new InvalidConsoleInput(
                'You must enter a valid URL, beginning with "http://" or "https://".',
            );
        };
    }
}
