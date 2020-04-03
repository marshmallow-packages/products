<?php

use Faker\Generator as Faker;
use Marshmallow\Priceable\Models\Price;
use Marshmallow\Product\Models\Product;
use Marshmallow\Priceable\Models\VatRate;

/**
 * factory(Marshmallow\Product\Models\Product::class, 10)->create();
 */
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'description' => $faker->paragraph(10),
    ];
});

$factory->afterCreating(Product::class, function ($product, $faker) {
    $product->prices()->create([
        'vatrate_id' => VatRate::get()->random()->id,
        'currency_id' => 1,
        'display_price' => $faker->randomNumber(3),
        'valid_from' => \Carbon\Carbon::now()
    ]);
});