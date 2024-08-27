<?php

namespace App\Http\Requests;

use App\Rules\NoNumberAndSymbol;
use App\Rules\NoTitle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers', 'name'),
                new NoTitle,
                new NoNumberAndSymbol,
            ],
            'place_of_birth' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:laki-laki,wanita',
            'occupation_id' => 'required|exists:occupations,id',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'deposit' => 'required|numeric',
        ];
    }
}
