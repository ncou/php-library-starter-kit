<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit;

use Composer\Script\Event;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

use function array_map;
use function implode;
use function preg_replace;

use const DIRECTORY_SEPARATOR;

class Setup
{
    private Event $event;
    private Filesystem $filesystem;
    private Finder $finder;
    private Project $project;
    private int $verbosity;

    public function __construct(
        Project $project,
        Event $event,
        Filesystem $filesystem,
        Finder $finder,
        int $verbosity
    ) {
        $this->project = $project;
        $this->event = $event;
        $this->filesystem = $filesystem;
        $this->finder = $finder;
        $this->verbosity = $verbosity;
    }

    /**
     * Returns the absolute path to the directory for the application
     */
    public function getAppPath(): string
    {
        return $this->project->getPath();
    }

    /**
     * Returns the Composer event that triggered this action
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * Returns a filesystem object to use when executing filesystem commands
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * Returns an object used to search for files or directories
     */
    public function getFinder(): Finder
    {
        return $this->finder::create();
    }

    /**
     * Returns the project name
     */
    public function getProjectName(): string
    {
        return $this->project->getName();
    }

    /**
     * Returns the project we are setting up
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * Returns the verbosity level
     */
    public function getVerbosity(): int
    {
        return $this->verbosity;
    }

    /**
     * Returns an instance used for executing a system command
     *
     * @param string[] $command
     */
    public function getProcess(array $command): Process
    {
        // Support backward-compatibility with older versions of symfony/process.
        $command = $this->useCorrectCommand($command);

        /**
         * @psalm-suppress PossiblyInvalidArgument
         * @phpstan-ignore-next-line
         */
        return new Process($command, $this->getProject()->getPath());
    }

    /**
     * @param string[] $command
     *
     * @return string[]|string
     *
     * @throws ReflectionException
     */
    private function useCorrectCommand(array $command)
    {
        $reflectedProcess = new ReflectionClass(Process::class);

        /** @var ReflectionMethod $reflectedConstructor */
        $reflectedConstructor = $reflectedProcess->getConstructor();
        $reflectedConstructorType = $reflectedConstructor->getParameters()[0]->getType();

        if ($reflectedConstructorType instanceof ReflectionNamedType) {
            if ($reflectedConstructorType->getName() === 'array') {
                return $command;
            }
        }

        $commandLine = array_shift($command) . ' ';
        $commandLine .= implode(' ', array_map(fn ($v) => escapeshellarg($v), $command));

        return $commandLine;
    }

    /**
     * Given a project-relative directory or filename, constructs an absolute path
     */
    public function path(string $fileName): string
    {
        return $this->getProject()->getPath() . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Returns a Build object used to process all the user inputs
     */
    public function getBuild(SymfonyStyle $console, Answers $answers): Build
    {
        return new Build(
            $this,
            $console,
            $answers,
        );
    }

    /**
     * Returns a Twig environment object for rendering Twig templates
     */
    public function getTwigEnvironment(): TwigEnvironment
    {
        $pregReplaceFilter = new TwigFilter(
            'preg_replace',
            fn (string $s, string $p, string $r): string => (string) preg_replace($p, $r, $s),
        );

        $twig = new TwigEnvironment(
            new FilesystemLoader($this->getProject()->getPath() . '/resources/templates'),
            [
                'debug' => true,
                'strict_variables' => true,
                'autoescape' => false,
            ],
        );

        $twig->addFilter($pregReplaceFilter);

        return $twig;
    }

    /**
     * Runs the steps to set up the project
     */
    public function run(SymfonyStyle $console, Answers $answers): void
    {
        $this->getBuild($console, $answers)->run();
    }
}
