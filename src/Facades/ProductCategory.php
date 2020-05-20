<?php 

namespace Marshmallow\Product\Facades;

class ProductCategory extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Product\ProductCategory::class;
    }
}