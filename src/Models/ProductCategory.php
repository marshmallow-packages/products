<?php

namespace Marshmallow\Product\Models;

use Marshmallow\Sluggable\HasSlug;
use Illuminate\Support\Collection;
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

    public function getTopLevelStructureIdArray()
    {
        $structure = [];
        $current_category = $this;
        $count = 0;
        while (true) {
            $count++;
            $current_category = $current_category->parent;
            if ($current_category) {
                $structure[] = $current_category->id;
            } else {
                break;
            }

            if ($count >= 10) {
                break;
            }
        }
        return $structure;
    }

    public function getChildrenStructureIdArray()
    {
        return $this->getChildrenRecursively($this)
            ->pluck('id')
            ->toArray();
    }

    public function getChildrenRecursively(ProductCategory $category, Collection $structure = null)
    {
        if (!$structure) {
            $structure = collect();
        }

        $children = $category->children;
        if ($children) {
            $children->each(function ($category) use (&$structure) {
                $structure[] = $category;
                $structure = $this->getChildrenRecursively($category, $structure);
            });
        }
        return $structure;
    }

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

    public function google()
    {
        return $this->belongsTo(GoogleProductCategory::class, 'google_product_category_id');
    }
}
