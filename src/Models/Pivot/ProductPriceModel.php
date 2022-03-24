<?php

namespace Nanuc\ProductComparison\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Translatable\HasTranslations;

class ProductPriceModel extends Pivot
{
    use HasTranslations;

    protected $translatable = ['comments'];
}
