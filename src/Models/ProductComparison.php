<?php

namespace Nanuc\ProductComparison\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComparison extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public static function byName($name)
    {
        return self::firstWhere('name', $name);
    }
}
