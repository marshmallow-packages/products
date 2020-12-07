<?php

namespace Marshmallow\Product\Nova\Relationships;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;

class ProductSupplier
{
    public static function withPivot()
    {
        return [
            'supplier_product_identifier',
            'purchase_price',
        ];
    }

    public static function fields()
    {
        return [
            Text::make(__('Supplier Product ID'), 'supplier_product_identifier'),
            Number::make(__('Purchase price'), 'purchase_price'),
        ];
    }
}
