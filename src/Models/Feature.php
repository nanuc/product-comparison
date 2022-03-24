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
}
