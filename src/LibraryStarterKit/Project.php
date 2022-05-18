<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit;

class Project
{
    private string $name;
    private string $path;

    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
