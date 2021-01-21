<?php

namespace Marshmallow\Product\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasSlug, SoftDeletes;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(config('app.models.product'))
                    ->withPivot(
                        config('product.nova.relationships.product_supplier')::withPivot()
                    );
    }
}
