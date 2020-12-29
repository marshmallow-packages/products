<?php

namespace Marshmallow\Product\Nova\Relationships;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Marshmallow\HelperFunctions\NovaRelationshipHelper;

class ProductSupplier extends NovaRelationshipHelper
{
    public static function withPivot(): array
    {
        return [
            'supplier_product_identifier',
            'purchase_price',
        ];
    }

    public static function fields(): array
    {
        return [
            Text::make(__('Supplier Product ID'), 'supplier_product_identifier'),
            Number::make(__('Purchase price'), 'purchase_price'),
        ];
    }
}
