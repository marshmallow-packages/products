<?php

namespace Marshmallow\Product\Rules;

use Illuminate\Contracts\Validation\Rule;
use Marshmallow\Product\Models\ProductCategory;

class ValidateParentCategory implements Rule
{
    protected $category;

    protected string $error_message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $category_id = null)
    {
        if ($category_id) {
            $this->category = ProductCategory::find($category_id);
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->category && $value == $this->category->id) {
            $this->message = __('The parent category cannot be the same as the current category.');
            return false;
        }

        if ($this->category) {
            $parents = $this->category->getTopLevelStructureIdArray();
            $children = $this->category->getChildrenStructureIdArray();

            $ids_in_structure = array_merge($parents, $children);

            if (in_array($value, $ids_in_structure)) {
                $this->message = __('This parent can not be added because it is already conflicts with the current structure.');
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
