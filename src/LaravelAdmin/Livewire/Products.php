<?php

namespace Nanuc\ProductComparison\LaravelAdmin\Livewire;

use Illuminate\Support\Arr;
use Nanuc\ProductComparison\Models\Feature;
use Nanuc\ProductComparison\Models\Product;

class Products extends BaseComponent
{
    protected $modelClass = Product::class;

    public $url;

    public $pivotValues = [];

    protected function getRenderParameters()
    {
        return [
            'productFeatures' => $this->model
                ?->features
                ->mapWithKeys(fn($productFeature) => [$productFeature->id => $productFeature->pivot])
                ->toArray(),
        ];
    }

    public function setFeature(Feature $feature, $value)
    {
        app()->setLocale($this->language);
        $this->model->features()->syncWithoutDetaching([$feature->id => compact('value')]);
        $this->model->load('features');
    }

    public function updatePivotValues($type, $index, $comments)
    {
        app()->setLocale($this->language);
        $this->pivotValues[$index][$type][$this->language] = $comments;

        $this->model->features()->syncWithoutDetaching([$index => [
            'comments' => Arr::get($this->pivotValues, $index . '.comments'),
            'value' => Arr::get($this->pivotValues, $index . '.value'),
        ]]);
        $this->model->load('features');
    }

    public function setPivotValues(Product $product)
    {
        $this->pivotValues = $product->features->mapWithKeys(fn($feature) => [$feature->id => $feature->pivot])->toArray();
    }
}

