<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Rules\UniqueRoleInOffice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            'role' => ['required', new Enum(Role::class)],
            'office_id' => [
                'required',
                'exists:offices,id',
                new UniqueRoleInOffice($this->input('role'), $this->input('office_id'))
            ],
        ];
    }
}
