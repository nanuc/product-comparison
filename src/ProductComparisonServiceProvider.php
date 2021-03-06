<?php

namespace Nanuc\ProductComparison;

use Livewire\Livewire;
use Nanuc\ProductComparison\Http\Livewire\Comparison;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ProductComparisonServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('product-comparison')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_product_comparison_table');

        Livewire::component('comparison', Comparison::class);

        Livewire::component('nanuc.product-comparison.laravel-admin.livewire.product-comparison', \Nanuc\ProductComparison\LaravelAdmin\Livewire\ProductComparison::class);
        Livewire::component('product-comparison.products', \Nanuc\ProductComparison\LaravelAdmin\Livewire\Products::class);
        Livewire::component('product-comparison.features', \Nanuc\ProductComparison\LaravelAdmin\Livewire\Features::class);
        Livewire::component('product-comparison.price-models', \Nanuc\ProductComparison\LaravelAdmin\Livewire\PriceModels::class);
    }
}
