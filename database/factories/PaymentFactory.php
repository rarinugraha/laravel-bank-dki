<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'registration_id' => Registration::factory(),
            'amount' => $this->faker->numberBetween(50000, 1000000),
            'payment_method' => $this->faker->randomElement(['Tunai', 'Kartu Kredit', 'Kartu Debit']),
            'payment_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
