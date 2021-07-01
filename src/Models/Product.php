<?php

namespace Marshmallow\Product\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Seoable\Traits\Seoable;
use Illuminate\Database\Eloquent\Builder;
use Marshmallow\Priceable\Traits\Priceable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\Nova\Flexible\Value\FlexibleCast;
use Marshmallow\Nova\Flexible\Concerns\HasFlexible;

/**
 * Is sluggable
 * Factory maakt een prijs aan
 * Kan meerdere prijzen hebben
 * Geeft 0 euro terug als er geen prijs is
 * Slug is uniek
 */

class Product extends Model
{
    use HasSlug;
    use Seoable;
    use Priceable;
    use SoftDeletes;
    use HasFlexible;

    const IN_STOCK = 'IN_STOCK';
    const OUT_OF_STOCK = 'OUT_OF_STOCK';
    const PREORDER = 'PREORDER';

    protected $guarded = [];

    protected $casts = [
        'images' => FlexibleCast::class,
    ];

    /**
     * Return the amount that can be purchased right now.
     */
    public function freeStock()
    {
        return 0;
    }

    public function fullname()
    {
        return $this->name;
    }

    public function hasImage()
    {
        return ($this->images->count() > 0);
    }

    public function firstImage()
    {
        return $this->images->first();
    }

    public function firstImagePath()
    {
        return asset('storage/' . $this->firstImage()->image);
    }

    public function getAvailability()
    {
        return self::IN_STOCK;
    }

    public function getCondition()
    {
        return 'new';
    }

    public function route()
    {
        return route('product.detail', $this);
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(
            config('product.models.product_category'),
            'product_category_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            config('product.models.product_category')
        );
    }

    public function suppliers()
    {
        return $this->belongsToMany(config('product.models.supplier'))
            ->withPivot(
                config('product.nova.relationships.product_supplier')::withPivot()
            );
    }
}
