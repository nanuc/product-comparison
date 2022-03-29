<?php

namespace Nanuc\ProductComparison\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Nanuc\ProductComparison\Enums\FeatureType;
use Nanuc\ProductComparison\Models\Pivot\ProductFeature;
use Nanuc\ProductComparison\Models\Pivot\ProductPriceModel;
use Spatie\Translatable\HasTranslations;
use AmrShawky\LaravelCurrency\Facade\Currency;

class Product extends Model
{
    use HasTranslations;

    protected $translatable = ['name', 'description', 'comments'];

    public function comparison()
    {
        return $this->belongsTo(ProductComparison::class, 'product_comparison_id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'product_feature')
            ->withPivot(['value', 'comments'])
            ->using(ProductFeature::class);
    }

    public function priceModels()
    {
        return $this->belongsToMany(PriceModel::class, 'product_price_model')
            ->withPivot(['comments', 'price', 'currency'])
            ->using(ProductPriceModel::class);
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

    public function getPrice(PriceModel $priceModel)
    {
        $priceData = $this->priceModels()->firstWhere('price_model_id', $priceModel->id)->pivot;

        if($priceData['currency'] != $this->comparison->currency) {
            $price = cache()->remember('price-model-' . $this->id . '-' . $priceModel->id, now()->addDays(3), function() use ($priceData) {
                return Currency::convert()
                    ->from($priceData['currency'])
                    ->to($this->comparison->currency)
                    ->amount($priceData['price'])
                    ->get();
            });
        }
        else {
            $price = $priceData['price'];
        }

        return round($price) . ' ' . $this->comparison->currency;
    }
}
