<?php

namespace Marshmallow\Product\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Priceable\Traits\Priceable;

/**
 * Is sluggable
 * Factory maakt een prijs aan
 * Kan meerdere prijzen hebben
 * Geeft 0 euro terug als er geen prijs is
 * Slug is uniek
 */

class Product extends Model
{
	use HasSlug, Priceable;

	protected $guarded = [];

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