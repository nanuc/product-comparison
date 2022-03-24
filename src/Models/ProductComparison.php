<?php

namespace Nanuc\ProductComparison\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductComparison extends Model
{
    use HasTranslations;

    protected $translatable = ['currency'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function priceModels()
    {
        return $this->hasMany(PriceModel::class);
    }

    public static function byName($name)
    {
        return self::firstWhere('name', $name);
    }
}
