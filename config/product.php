<?php

return [

    /**
     * Models
     */
    'models' => [
        'product_category' => \Marshmallow\Product\Models\ProductCategory::class,
        'supplier' => \Marshmallow\Product\Models\Supplier::class,
        'product' => \Marshmallow\Product\Models\Product::class,
    ],

	/**
	 * Overschrijf nova settings. Door zoveel mogelijk beheerbaar
	 * te maken in deze config, deste kleiner is de kans dat de
	 * Nova Stubs overschreven gaan worden. Dit is met het oogpunt
	 * op updates wel erg fijn.
	 */
	'nova' => [
		'wysiwyg' => env('NOVA_WYSIWYG', \Laravel\Nova\Fields\Trix::class),

		'prices_are_including_vat' => true,

		'defaults' => [
			'currencies' => 1,
			'vat_rates' => 3,
		],
        'resources' => [
            'product_category' => \Marshmallow\Product\Nova\ProductCategory::class,
            'price' => \Marshmallow\Priceable\Nova\Price::class,
            'supplier' => \Marshmallow\Product\Nova\Supplier::class,
            'product' => \Marshmallow\Product\Nova\Product::class,
        ],
        'relationships' => [
            'product_supplier' => \Marshmallow\Product\Nova\Relationships\ProductSupplier::class,
        ],
	],

	'default_product_view' => 'shop.product',

	'channels' => [
		// \Marshmallow\Channels\BolCom\Facades\BolComNovaChannel::class
	]
];
