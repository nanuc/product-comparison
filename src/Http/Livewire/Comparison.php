<?php

namespace Nanuc\ProductComparison\Http\Livewire;

use Livewire\Component;
use Nanuc\ProductComparison\Enums\FeatureType;
use Nanuc\ProductComparison\Models\Feature;
use Nanuc\ProductComparison\Models\Product;
use Nanuc\ProductComparison\Models\ProductComparison;

class Comparison extends Component
{
    public ProductComparison $comparison;
    public $selectedProducts = [];
    public $selectedFeatures = [];

    public function mount()
    {
        $this->selectedProducts = $this->comparison->products->pluck('id');
        $this->selectedFeatures = $this->comparison
            ->features
            ->filter(fn(Feature $feature) => in_array($feature->type, [FeatureType::ENUM, FeatureType::BOOLEAN]))
            ->mapWithKeys(function (Feature $feature) {
                if($feature->type == FeatureType::ENUM) {
                    return [$feature->id => $feature->getOptions()];
                }

                return [$feature->id => []];
            })
            ->toArray();
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
            ->whereIn('id', $this->selectedProducts)
            ->filter(fn(Product $product) => $this->productIsVisible($product));
    }

    private function productIsVisible(Product $product)
    {
        $productFeatures = $product->getFeatures();

        foreach($this->selectedFeatures as $featureId => $selectedItems) {
            $feature = Feature::find($featureId);

            if($feature->type == FeatureType::BOOLEAN) {
                foreach($selectedItems as $selectedItem) {
                    if(!$productFeatures[$selectedItem]) {
                        return false;
                    }
                }
            }
            elseif($feature->type == FeatureType::ENUM) {
                if(!in_array($productFeatures[$featureId], $selectedItems)) {
                    return false;
                }
            }
        }

        return true;
    }
}
