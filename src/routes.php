<?php

Route::group(['namespace' => 'Marshmallow\Product\Http\Controllers'], function () {
    // Route::post('/', 'ProductController@index');
    Route::get('/feeds/products/google', 'ProductFeedController@google');
    // Route::get('/shop/{product:slug}', 'ProductController@show')->name('product.detail');
});
