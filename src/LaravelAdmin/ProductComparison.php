<?php

namespace Nanuc\ProductComparison\LaravelAdmin;

use Nanuc\LaravelAdmin\Modules\AdminModule;

class ProductComparison extends AdminModule
{
    protected $caption = 'Product Comparison';
    protected $action = \Nanuc\ProductComparison\LaravelAdmin\Livewire\ProductComparison::class;
    protected $icon = 'puzzle';
}
