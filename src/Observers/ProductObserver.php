<?php

namespace Marshmallow\Product\Observers;

use Marshmallow\Product\Models\Product;
use Marshmallow\Channels\Channable\Facades\Channable;

class ProductObserver
{
    public function created(Product $product)
    {
    	/**
    	 * Handle channels like bol.com etc.
    	 */
    	if (class_exists(Channable::class)) {
    		Channable::observe('created', $product);
    	}
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //

        /**
    	 * Handle channels like bol.com etc.
    	 */
    	if (class_exists(Channable::class)) {
    		Channable::observe('updated', $product);
    	}
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //

        /**
    	 * Handle channels like bol.com etc.
    	 */
    	if (class_exists(Channable::class)) {
    		Channable::observe('deleted', $product);
    	}
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //

        /**
    	 * Handle channels like bol.com etc.
    	 */
    	if (class_exists(Channable::class)) {
    		Channable::observe('restored', $product);
    	}
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //

        /**
    	 * Handle channels like bol.com etc.
    	 */
    	if (class_exists(Channable::class)) {
    		Channable::observe('forceDeleted', $product);
    	}
    }
}
