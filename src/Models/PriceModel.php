<?php

namespace Nanuc\ProductComparison\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PriceModel extends Model
{
    use HasTranslations;

    protected $translatable = ['name', 'description', 'comments'];
}
