<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoNumberAndSymbol implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match('/[0-9]/', $value) || preg_match('/[^\p{L}\s]/u', $value)) {
            return false;
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
        return 'The :attribute may not contain numbers or symbols';
    }
}
