<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit;

use Chiron\Dev\LibraryStarterKit\Answers;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Vendor\Test\SubNamespace\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected Answers $answers;

    protected function setUp(): void
    {
        parent::setUp();

        $filesystem = $this->mockery(Filesystem::class);
        $filesystem->expects()->exists('/path/to/answers.json')->andReturnFalse();

        $this->answers = new Answers('/path/to/answers.json', $filesystem);
    }
}
