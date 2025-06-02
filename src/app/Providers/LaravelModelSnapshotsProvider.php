<?php

namespace Silaswint\LaravelModelSnapshots\App\Providers;

use DirectoryIterator;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelModelSnapshotsProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-model-snapshots')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });

        $this->handleMigrations($package);
    }

    private function handleMigrations(Package $package): void
    {
        // Load migrations
        $iterator = new DirectoryIterator(__DIR__.'/../database/migrations/');
        $migrations = collect();

        foreach ($iterator as $route) {
            /** @var DirectoryIterator $route */
            if ($route->isDot()) {
                continue;
            }

            $migrations->push(
                (string) str($route->getFilename())->before('.php')
            );
        }

        // Register migrations
        $package->hasMigrations(
            $migrations
                ->sort() // sort alphabetically
                ->toArray()
        );
    }
}
