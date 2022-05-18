<?php

declare(strict_types=1);

namespace Chiron\Dev\LibraryStarterKit\Console;

use Chiron\Dev\LibraryStarterKit\Answers;
use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorEmail;
use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorHoldsCopyright;
use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorName;
use Chiron\Dev\LibraryStarterKit\Console\Question\AuthorUrl;
use Chiron\Dev\LibraryStarterKit\Console\Question\CodeOfConduct;
use Chiron\Dev\LibraryStarterKit\Console\Question\CodeOfConductCommittee;
use Chiron\Dev\LibraryStarterKit\Console\Question\CodeOfConductEmail;
use Chiron\Dev\LibraryStarterKit\Console\Question\CodeOfConductPoliciesUrl;
use Chiron\Dev\LibraryStarterKit\Console\Question\CodeOfConductReportingUrl;
use Chiron\Dev\LibraryStarterKit\Console\Question\CopyrightEmail;
use Chiron\Dev\LibraryStarterKit\Console\Question\CopyrightHolder;
use Chiron\Dev\LibraryStarterKit\Console\Question\CopyrightUrl;
use Chiron\Dev\LibraryStarterKit\Console\Question\CopyrightYear;
use Chiron\Dev\LibraryStarterKit\Console\Question\GithubUsername;
use Chiron\Dev\LibraryStarterKit\Console\Question\License;
use Chiron\Dev\LibraryStarterKit\Console\Question\PackageDescription;
use Chiron\Dev\LibraryStarterKit\Console\Question\PackageKeywords;
use Chiron\Dev\LibraryStarterKit\Console\Question\PackageName;
use Chiron\Dev\LibraryStarterKit\Console\Question\PackageNamespace;
use Chiron\Dev\LibraryStarterKit\Console\Question\SecurityPolicy;
use Chiron\Dev\LibraryStarterKit\Console\Question\SecurityPolicyContactEmail;
use Chiron\Dev\LibraryStarterKit\Console\Question\SecurityPolicyContactFormUrl;
use Chiron\Dev\LibraryStarterKit\Console\Question\StarterKitQuestion;
use Chiron\Dev\LibraryStarterKit\Console\Question\VendorName;
use Symfony\Component\Console\Question\Question as SymfonyQuestion;

/**
 * A list of questions to ask the user upon installation
 */
class InstallQuestions
{
    /**
     * @return array<StarterKitQuestion & SymfonyQuestion>
     */
    public function getQuestions(Answers $answers): array
    {
        return [
            new GithubUsername($answers),
            new VendorName($answers),
            new PackageName($answers),
            new PackageDescription($answers),
            new AuthorName($answers),
            new AuthorEmail($answers),
            new AuthorUrl($answers),
            new AuthorHoldsCopyright($answers),
            new CopyrightHolder($answers),
            new CopyrightEmail($answers),
            new CopyrightUrl($answers),
            new CopyrightYear($answers),
            new License($answers),
            new SecurityPolicy($answers),
            new SecurityPolicyContactEmail($answers),
            new SecurityPolicyContactFormUrl($answers),
            new CodeOfConduct($answers),
            new CodeOfConductEmail($answers),
            new CodeOfConductCommittee($answers),
            new CodeOfConductPoliciesUrl($answers),
            new CodeOfConductReportingUrl($answers),
            new PackageKeywords($answers),
            new PackageNamespace($answers),
        ];
    }
}
