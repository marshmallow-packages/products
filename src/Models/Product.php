<?php

namespace Marshmallow\Product\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Marshmallow\Priceable\Traits\HasPrice;
use Marshmallow\Priceable\Traits\Priceable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\Product\Models\ProductCategory;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

/**
 * Is sluggable
 * Factory maakt een prijs aan
 * Kan meerdere prijzen hebben
 * Geeft 0 euro terug als er geen prijs is
 * Slug is uniek
 */

class Product extends Model
{
    use HasFlexible;

    const IN_STOCK = 'IN_STOCK';
    const OUT_OF_STOCK = 'OUT_OF_STOCK';
    const PREORDER = 'PREORDER';

	use HasSlug, Priceable, SoftDeletes;

	protected $guarded = [];

    protected $casts = [
        'images' => FlexibleCast::class
    ];

    public function fullname ()
    {
        return $this->name;
    }

    public function hasImage ()
    {
        return ($this->images->count() > 0);
    }

    public function firstImage ()
    {
        return $this->images->first();
    }

    public function firstImagePath ()
    {
        return asset('storage/' . $this->firstImage()->image);
    }

    public function getAvailability ()
    {
        return self::IN_STOCK;
    }

    public function getCondition ()
    {
        return 'new';
    }

    public function route ()
    {
        return route('product.detail', $this);
    }

    public function scopeActive (Builder $builder)
    {
        $builder->where('active', 1);
    }

    public function category ()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function categories ()
    {
        return $this->belongsToMany(ProductCategory::class);
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