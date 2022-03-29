<?php

namespace Nanuc\ProductComparison\LaravelAdmin\Livewire;

use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Nanuc\ProductComparison\Exports\ProductExport;
use Nanuc\ProductComparison\Models\Feature;
use Nanuc\ProductComparison\Models\Product;

class Products extends BaseComponent
{
    protected $modelClass = Product::class;

    public $url;

    public $featureValues = [];
    public $priceValues = [];

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

    public function updateFeatureValues($type, $index, $comments)
    {
        app()->setLocale($this->language);
        $this->featureValues[$index][$type][$this->language] = $comments;

        $this->model->features()->syncWithoutDetaching([$index => [
            'comments' => Arr::get($this->featureValues, $index . '.comments'),
            'value' => Arr::get($this->featureValues, $index . '.value'),
        ]]);
        $this->model->load('features');
    }

    public function updatePriceValues($type, $index, $value)
    {
        app()->setLocale($this->language);
        if($type == 'comments') {
            $this->priceValues[$index][$type][$this->language] = $value;
        }
        else {
            $this->priceValues[$index][$type] = $value;
        }

        $this->model->priceModels()->syncWithoutDetaching([$index => [
            'comments' => Arr::get($this->priceValues, $index . '.comments'),
            'price' => Arr::get($this->priceValues, $index . '.price'),
            'currency' => Arr::get($this->priceValues, $index . '.currency'),
        ]]);
        $this->model->load('priceModels');
    }

    public function setFeatureValues(Product $product)
    {
        $this->featureValues = $product->features->mapWithKeys(fn($feature) => [$feature->id => $feature->pivot])->toArray();
    }

    public function setPriceValues(Product $product)
    {
        $this->priceValues = $product->priceModels->mapWithKeys(fn($priceModel) => [$priceModel->id => $priceModel->pivot])->toArray();

    }

    public function downloadExcel($language)
    {
        return Excel::download(new ProductExport($this->model, $language), $this->model->name . '.xlsx');
    }
}

