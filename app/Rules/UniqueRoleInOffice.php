<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueRoleInOffice implements Rule
{
    protected $role;
    protected $office_id;

    public function __construct($role, $office_id)
    {
        $this->role = $role;
        $this->office_id = $office_id;
    }

    public function passes($attribute, $value)
    {
        return !User::where('role', $this->role)
            ->where('office_id', $this->office_id)
            ->exists();
    }

    public function message()
    {
        return 'A user with the same role and office already exists.';
    }
}
