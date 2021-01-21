<?php

namespace Marshmallow\Product\Facades;

class Product extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Product\Product::class;
    }
}
