<?php

namespace Nanuc\ProductComparison\LaravelAdmin\Livewire;

use Livewire\Component;
use Nanuc\ProductComparison\Models\Product;

class Products extends Component
{
    public \Nanuc\ProductComparison\Models\ProductComparison $productComparison;
    public Product $product;
    public $language;

    protected $listeners = [
        'updatedLanguage',
    ];

    public function render()
    {
        return view('product-comparison::admin.products');
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function updatedLanguage($language)
    {
        $this->language = $language;
    }
}

