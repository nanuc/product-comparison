<?php

namespace Nanuc\ProductComparison\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nanuc\ProductComparison\ProductComparison
 */
class ProductComparison extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-comparison';
    }
}
