<?php

namespace Finller\Pappers;

use Finller\Pappers\Integrations\Pappers\PappersConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PappersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-pappers')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->scoped(Pappers::class, function () {

            return new Pappers(new PappersConnector(
                token: config('pappers.token'),
                version: config('pappers.version') ?? 'v2',
            ));
        });
    }
}
