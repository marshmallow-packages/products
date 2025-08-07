<?php

namespace Marshmallow\Product;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(
            __DIR__.'/../config/product.php',
            'product'
        );

        $this->app->singleton(Product::class, function () {
            return new Product();
        });

        $this->app->alias(Product::class, 'product');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Views
         */
        // $this->loadViewsFrom(__DIR__.'/views', 'marshmallow');

        // $this->loadFactoriesFrom(__DIR__.'/../database/factories'); // Deprecated in Laravel 8+

        $this->publishes([
            __DIR__.'/../config/product.php' => config_path('product.php'),
        ], 'config');


        /**
         * Routes
         */
        // $this->loadRoutesFrom(__DIR__.'/routes.php'); // Removed - routes file deleted

        if ($this->app->runningInConsole()) {
            $this->commands([
                // InstallCommand::class,
            ]);
        }
    }
}
