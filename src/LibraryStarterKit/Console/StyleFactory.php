<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A factory useful for creating a Style instance
 */
class StyleFactory
{
    public function factory(InputInterface $input, OutputInterface $output): Style
    {
        return new Style($input, $output);
    }
}
