<?php

namespace Nanuc\ProductComparison;

use Livewire\Livewire;
use Nanuc\ProductComparison\Http\Livewire\Comparison;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Nanuc\ProductComparison\Commands\ProductComparisonCommand;

class ProductComparisonServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('product-comparison')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_product_comparison_table');

        Livewire::component('comparison', Comparison::class);
    }
}
