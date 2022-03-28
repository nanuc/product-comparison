<?php

namespace Nanuc\ProductComparison\LaravelAdmin\Livewire;

use Nanuc\LaravelAdmin\Modules\ModuleComponent;

class ProductComparison extends ModuleComponent
{
    protected $title = 'Product Comparison';
    protected $view = 'product-comparison::admin.product-comparison';

    public \Nanuc\ProductComparison\Models\ProductComparison $productComparison;
    public $activeTab = 'products';

    public function setProductComparison(\Nanuc\ProductComparison\Models\ProductComparison $productComparison)
    {
        $this->productComparison = $productComparison;
    }
}

