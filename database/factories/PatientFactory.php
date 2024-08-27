<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition()
    {
        $gender = $this->faker->randomElement(['Laki-Laki', 'Perempuan']);

        return [
            'medical_record_number' => $this->faker->unique()->numerify('MRN-######'),
            'nik' => $this->faker->unique()->numerify('################'),
            'name' => $this->faker->name($gender),
            'place_of_birth' => $this->faker->city,
            'birth_date' => $this->faker->date(),
            'gender' => $gender,
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'address' => $this->faker->address,
            'rt' => $this->faker->numerify('##'),
            'rw' => $this->faker->numerify('##'),
            'kelurahan' => $this->faker->word,
            'kecamatan' => $this->faker->word,
            'religion' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']),
            'marital_status' => $this->faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati']),
            'occupation' => $this->faker->jobTitle,
            'phone_number' => $this->faker->phoneNumber,
        ];
    }
}
