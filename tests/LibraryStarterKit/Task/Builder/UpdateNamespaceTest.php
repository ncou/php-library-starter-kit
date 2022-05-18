<?php

declare(strict_types=1);

namespace Chiron\Test\Dev\LibraryStarterKit\Task\Builder;

use ArrayObject;
use Mockery\MockInterface;
use Chiron\Dev\LibraryStarterKit\Filesystem;
use Chiron\Dev\LibraryStarterKit\Setup;
use Chiron\Dev\LibraryStarterKit\Task\Build;
use Chiron\Dev\LibraryStarterKit\Task\Builder\UpdateNamespace;
use Chiron\Test\Dev\LibraryStarterKit\SnapshotsTool;
use Chiron\Test\Dev\LibraryStarterKit\TestCase;
use Chiron\Test\Dev\LibraryStarterKit\WindowsSafeTextDriver;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use function file_get_contents;

class UpdateNamespaceTest extends TestCase
{
    use SnapshotsTool;

    /**
     * @dataProvider provideNamespaceTestValues
     */
    public function testBuild(
        string $packageName,
        string $namespace,
        string $testNamespace
    ): void {
        $console = $this->mockery(SymfonyStyle::class);
        $console->expects()->section('Updating namespace');

        $this->answers->packageName = $packageName;
        $this->answers->packageNamespace = $namespace;

        $file1 = $this->mockery(SplFileInfo::class, [
            'getRealPath' => '/path/to/app/src/Foo.php',
            'getContents' => $this->getFileContents(),
        ]);

        $file2 = $this->mockery(SplFileInfo::class, [
            'getRealPath' => '/path/to/app/src/Bar.php',
            'getContents' => $this->getFileContents(),
        ]);

        $file3 = $this->mockery(SplFileInfo::class, [
            'getRealPath' => '/path/to/app/composer.json',
            'getContents' => $this->getFileContents(),
        ]);

        $finder1 = $this->mockery(Finder::class, [
            'getIterator' => new ArrayObject([$file1, $file2]),
        ]);
        $finder1->expects()->exclude(['LibraryStarterKit'])->andReturnSelf();
        $finder1->expects()->in(
            [
                '/path/to/app/bin',
                '/path/to/app/src',
                '/path/to/app/tests',
            ],
        )->andReturnSelf();
        $finder1->expects()->files()->andReturnSelf();
        $finder1->expects()->name('*.php')->andReturnSelf();

        $finder2 = $this->mockery(Finder::class, [
            'getIterator' => new ArrayObject([$file3]),
        ]);
        $finder2->expects()->in(['/path/to/app'])->andReturnSelf();
        $finder2->expects()->files()->andReturnSelf();
        $finder2->expects()->depth('== 0')->andReturnSelf();
        $finder2->expects()->name('composer.json')->andReturnSelf();

        $filesystem = $this->mockery(Filesystem::class);

        $filesystem
            ->shouldReceive('dumpFile')
            ->times(3)
            ->withArgs(function (string $path, string $contents) {
                $this->assertMatchesSnapshot($path, new WindowsSafeTextDriver());
                $this->assertMatchesSnapshot($contents, new WindowsSafeTextDriver());

                return true;
            });

        $environment = $this->mockery(Setup::class, [
            'getAppPath' => '/path/to/app',
            'getFilesystem' => $filesystem,
        ]);

        $environment
            ->shouldReceive('path')
            ->andReturnUsing(fn (string $path): string => '/path/to/app/' . $path);

        $environment
            ->shouldReceive('getFinder')
            ->twice()
            ->andReturn($finder1, $finder2);

        /** @var Build & MockInterface $task */
        $task = $this->mockery(Build::class, [
            'getAnswers' => $this->answers,
            'getConsole' => $console,
            'getSetup' => $environment,
        ]);

        $builder = new UpdateNamespace($task);

        $builder->build();
    }

    /**
     * @return array<array<array-key, string>>
     */
    public function provideNamespaceTestValues(): array
    {
        return [
            [
                'packageName' => 'acme/foo-bar',
                'namespace' => 'Acme\\Foo\\Bar',
                'testNamespace' => 'Acme\\Test\\Foo\\Bar',
            ],
            [
                'packageName' => 'acme/foo',
                'namespace' => 'Acme',
                'testNamespace' => 'Acme\\Test',
            ],
            [
                'packageName' => 'another/package',
                'namespace' => 'Another\\Package\\With\\Long\\Namespace',
                'testNamespace' => 'Another\\Test\\Package\\With\\Long\\Namespace',
            ],
        ];
    }

    private function getFileContents(): string
    {
        return (string) file_get_contents(__DIR__ . '/fixtures/update-namespace-test.php');
    }
}