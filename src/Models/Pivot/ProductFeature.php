<?php

namespace Nanuc\ProductComparison\Models\Pivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nanuc\ProductComparison\Enums\FeatureType;
use Spatie\Translatable\HasTranslations;

class ProductFeature extends Pivot
{
    use HasTranslations;

    protected $translatable = ['value', 'comments'];
}
