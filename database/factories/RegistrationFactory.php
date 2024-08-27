<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Patient;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition()
    {
        return [
            'patient_id' => Patient::factory(),
            'department_id' => Department::factory(),
            'registration_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(['Terdaftar', 'Dibatalkan', 'Lunas']),
        ];
    }
}
