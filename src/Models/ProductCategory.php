<?php

namespace Marshmallow\Product\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Product\Models\Product;
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

    public function products ()
    {
        return $this->belongsToMany(Product::class);
    }

    public function google ()
    {
        return $this->belongsTo(GoogleProductCategory::class, 'google_product_category_id');
    }

	/**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}