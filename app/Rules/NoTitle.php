<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoTitle implements Rule
{
    protected $forbiddenTitles = [
        'hj',
        'haji',
        'prof',
        'profesor',
        'mr',
        'ms',
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->forbiddenTitles as $title) {
            if (stripos($value, $title) !== false) {
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
        return 'The :attribute may not contain titles';
    }
}
