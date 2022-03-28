<?php

namespace Nanuc\ProductComparison\LaravelAdmin\Livewire;

use Nanuc\LaravelAdmin\Modules\ModuleComponent;

class ProductComparison extends ModuleComponent
{
    protected $title = 'Product Comparison';
    protected $view = 'product-comparison::admin.product-comparison';

    public \Nanuc\ProductComparison\Models\ProductComparison $productComparison;
    public $activeTab = 'products';
    public $language = 'de';
    public $allLanguages = ['de', 'en'];

    public function setProductComparison(\Nanuc\ProductComparison\Models\ProductComparison $productComparison)
    {
        $this->productComparison = $productComparison;
    }

    public function updatedLanguage($language)
    {
        $this->emit('updatedLanguage', $language);
    }
}

