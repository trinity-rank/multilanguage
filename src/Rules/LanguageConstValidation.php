<?php

namespace Trinityrank\Multilanguage\Rules;

use App\Articles\Article;
use Illuminate\Contracts\Validation\Rule;

class LanguageConstValidation implements Rule
{
    public $categoryData;
    public $postType;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request, $self, $model)
    {
        $this->language_code = $request->multilang_language;
        $this->item_id = $self->id;
        $this->model = $model;
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
        if( empty($value) ) {
            return true;
        }

        $item = $this->model::where('multilang_const', $value)->where('multilang_language', $this->language_code);

        if( $item->first() == null ) {
            return true;
        }

        return $item->first()->id !== $this->item_id ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CONST field must be unique.';
    }
}
