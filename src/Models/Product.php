<?php

namespace Nanuc\ProductComparison\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Nanuc\ProductComparison\Enums\FeatureType;
use Nanuc\ProductComparison\Models\Pivot\ProductFeature;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $translatable = ['name', 'description', 'comments'];

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'product_feature')
            ->withPivot('value')
            ->using(ProductFeature::class);
    }

    public function getFeatures()
    {
        return $this->features
            ->mapWithKeys(fn(Feature $feature) => [$feature->id => $feature->pivot->value])
            ->toArray();
    }

    public function getFeature(Feature $feature) {
        return Arr::get($this->getFeatures(), $feature->id);
    }

    public function renderFeature(Feature $feature)
    {
        $value = $this->getFeature($feature);

        if($feature->type == FeatureType::BOOLEAN) {
            if(is_null($value)) {
                return view('product-comparison::feature.unknown')->render();
            }
            return view($value ? 'product-comparison::feature.true' : 'product-comparison::feature.false')->render();
        }
        elseif($feature->type == FeatureType::ENUM) {
            return view('product-comparison::feature.enum', ['text' => $value])->render();
        }
        elseif($feature->type == FeatureType::TEXT) {
            return view('product-comparison::feature.text', ['text' => $value])->render();
        }
    }
}
