<?php

namespace Marshmallow\Product\Nova;

use App\Nova\Resource;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Marshmallow\Seoable\Seoable;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\BelongsToMany;
use Marshmallow\Nova\Flexible\Flexible;
use Marshmallow\Channels\Channable\Traits\ProductResourceChannel;

class Product extends Resource
{
    use ProductResourceChannel;

    public static $group = 'Products';

    public static $group_icon = '<svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon" height="24" viewBox="0 0 24 24" width="24"><path fill="var(--sidebar-icon)" d="M11 15h2v2h-2v-2zm0-8h2v6h-2V7zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>';
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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            (new Tabs(
                'Product Details',
                array_merge(
                    [
                        'Default' => [
                            ID::make()->sortable(),
                            Text::make(__('Name'), 'name')->sortable(),
                            BelongsTo::make(__('Product Category'), 'category', config('product.nova.resources.product_category')),
                            config('product.nova.wysiwyg')::make(__('Intro'), 'intro'),
                            config('product.nova.wysiwyg')::make(__('Description'), 'description'),

                            Text::make(__('GTIN'), 'gtin')->help(__('This should be the EAN number of this product.')),
                            Text::make(__('MPN'), 'mpn')->help(
                                __('This is the product number of the manufacturer. This is only required if there is no GTIN available.')
                            ),
                            Boolean::make(__('Active'), 'active'),
                        ],

                        'Media' => [
                            Flexible::make(__('Images'))
                                ->addLayout(__('Image'), 'images', [
                                    Image::make(__('Image'), 'image'),
                                    Text::make(__('Alt text'), 'alt_text'),
                                ])->button(__('Add another image')),
                        ],
                        'SEO' => [
                            Seoable::make('SEO'),
                        ],
                    ],
                    $this->addChannelTabs()
                )
            ))->withToolbar(),

            MorphMany::make(__('Prices'), 'prices', config('product.nova.resources.price')),
            BelongsToMany::make(__('Product Category'), 'categories', config('product.nova.resources.product_category')),
            BelongsToMany::make(__('Suppliers'), 'suppliers', config('product.nova.resources.supplier'))->fields(function () {
                return config('product.nova.relationships.product_supplier')::fields();
            }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
