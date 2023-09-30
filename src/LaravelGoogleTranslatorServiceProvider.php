<?php

namespace Webtamizhan\LaravelGoogleTranslator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webtamizhan\LaravelGoogleTranslator\Commands\LaravelGoogleTranslatorCommand;

class LaravelGoogleTranslatorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-google-translator')
            ->hasConfigFile()
            ->hasMigration('create_laravel-google-translator_table')
            ->hasCommand(LaravelGoogleTranslatorCommand::class);
    }
}
