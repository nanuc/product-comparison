<?php

namespace Nanuc\ProductComparison\Models;

use Illuminate\Database\Eloquent\Model;
use Nanuc\ProductComparison\Enums\FeatureType;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{
    use HasTranslations;

    protected $translatable = ['name', 'description', 'comments'];

    protected $casts = [
        'type' => FeatureType::class,
    ];

    public function comparison()
    {
        return $this->belongsTo(ProductComparison::class, 'product_comparison_id');
    }

    public function getOptions()
    {
        return $this->comparison
            ->products
            ->map(fn(Product $product) => $product->features->firstWhere('id', $this->id)->pivot->value)
            ->unique()
            ->sort()
            ->values();
    }
}
