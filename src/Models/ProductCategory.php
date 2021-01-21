<?php

namespace Marshmallow\Product\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\Datasets\GoogleProductCategories\Models\GoogleProductCategory;

/**
 * Is sluggable
 * Factory maakt een prijs aan
 * Kan meerdere prijzen hebben
 * Geeft 0 euro terug als er geen prijs is
 * Slug is uniek
 */

class ProductCategory extends Model
{
    use HasSlug, SoftDeletes;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(
            config('product.models.product')
        );
    }

    public function google()
    {
        return $this->belongsTo(GoogleProductCategory::class, 'google_product_category_id');
    }
}
