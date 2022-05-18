<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Console;

use Chiron\Dev\LibraryStarterKit\Console\StyleFactory;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class StyleFactoryTest extends TestCase
{
    public function testFactory(): void
    {
        $input = new ArgvInput([]);
        $output = new NullOutput();
        $factory = new StyleFactory();

        $this->assertInstanceOf(SymfonyStyle::class, $factory->factory($input, $output));
    }
}
