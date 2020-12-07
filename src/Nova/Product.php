<?php

namespace Marshmallow\Product\Nova;

use App\Nova\Resource;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\BelongsToMany;
use Marshmallow\Nova\Flexible\Flexible;
use Marshmallow\Channels\Channable\Traits\ProductResourceChannel;

class Product extends Resource
{
	use TabsOnEdit;
	use ProductResourceChannel;

    public static $group = 'Products';

    public static $group_icon = '<svg viewBox="0 0 20 20" class="sidebar-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="icon-shape"><path fill="var(--sidebar-icon)" d="M7,0 L6,0 L0,3 L0,9 L4,8 L4,20 L16,20 L16,8 L20,9 L20,3 L14,0 L13,0 C13,1.65685425 11.6568542,3 10,3 C8.34314575,3 7,1.65685425 7,0 Z" id="Combined-Shape"></path></g></g></svg>';

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
        	(new Tabs(
        		'Product Details',
	        	array_merge(
	        		[
		                'Default' => [
		                    ID::make()->sortable(),
				            Text::make('Name')->sortable(),
				            BelongsTo::make('ProductCategory', 'category'),
				            config('product.nova.wysiwyg')::make('Intro'),
				            config('product.nova.wysiwyg')::make('Description'),

				            Text::make('GTIN')->help('This should be the EAN number of this product.'),
				            Text::make('MPN')->help('This is the product number of the manufacturer. This is only required if there is no GTIN available.'),
				            Boolean::make('Active'),
		                ],

		                'Media' => [
		                	Flexible::make('Images')
			                    ->addLayout('Image', 'images', [
			                        Image::make('Image'),
			                        Text::make('Alt text'),
			                    ])->button('Add another image'),
		                ],
		            ],
		            $this->addChannelTabs()
	        	)
	        ))->withToolbar(),

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
