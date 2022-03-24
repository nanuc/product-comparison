<?php

namespace Nanuc\ProductComparison\Http\Livewire;

use Livewire\Component;
use Nanuc\ProductComparison\Models\ProductComparison;

class Comparison extends Component
{
    public ProductComparison $comparison;
    public $selectedProducts = [];

    public function mount()
    {
        $this->selectedProducts = $this->comparison->products->pluck('id');
    }

    public function render()
    {
        return view('product-comparison::livewire.comparison', [
            'products' => $this->getProducts(),
        ]);
    }

    private function getProducts()
    {
        return $this->comparison->products
            ->whereIn('id', $this->selectedProducts);
    }
}
