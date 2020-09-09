<?php

return [

	/**
	 * Overschrijf nova settings. Door zoveel mogelijk beheerbaar
	 * te maken in deze config, deste kleiner is de kans dat de
	 * Nova Stubs overschreven gaan worden. Dit is met het oogpunt
	 * op updates wel erg fijn.
	 */
	'nova' => [
		'wysiwyg' => \Laravel\Nova\Fields\Trix::class,

		'prices_are_including_vat' => true,

		'defaults' => [
			'currencies' => 1,
			'vat_rates' => 3,
		],
	],

	'default_product_view' => 'shop.product',

	'channels' => [
		\Marshmallow\Channels\BolCom\Facades\BolComNovaChannel::class
	]
];
