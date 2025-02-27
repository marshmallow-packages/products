<?php

namespace Marshmallow\Product\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function parent()
    {
        return $this->belongsTo(
            config('product.models.product_category'),
            'parent_id'
        );
    }

    public function children()
    {
        return $this->hasMany(
            config('product.models.product_category'),
            'parent_id'
        );
    }
}
