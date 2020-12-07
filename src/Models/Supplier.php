<?php

namespace Marshmallow\Product\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\Product\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasSlug, SoftDeletes;

    protected $guarded = [];

    public function products ()
    {
        return $this->belongsToMany(Product::class);
    }
}
