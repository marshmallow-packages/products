<?php

namespace Marshmallow\Product\Nova;

use App\Nova\Resource;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\BelongsToMany;
use Whitecube\NovaFlexibleContent\Flexible;

class Product extends Resource
{
    public static $group = 'Products';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\Product\Models\Product';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->sortable(),
            BelongsTo::make('ProductCategory', 'category'),
            config('product.nova.wysiwyg')::make('Intro'),
            config('product.nova.wysiwyg')::make('Description'),

            Text::make('GTIN')->help('This should be the EAN number of this product.'),
            Text::make('MPN')->help('This is the product number of the manufacturer. This is only required if there is no GTIN available.'),
            Boolean::make('Active'),

            new Panel('Images', [
                Flexible::make('Images')
                    ->addLayout('Image', 'images', [
                        Image::make('Image'),
                        Text::make('Alt text'),
                    ])->button('Add another image')
                ]),

            MorphMany::make('Prices', 'prices'),

            BelongsToMany::make('ProductCategory', 'categories')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
