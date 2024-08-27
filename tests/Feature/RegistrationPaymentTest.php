<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationPaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $operator;
    protected $registration;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->operator = User::factory()->create(['role' => 'operator']);

        $patient = Patient::factory()->create();
        $department = Department::factory()->create();
        $this->registration = Registration::factory()->create([
            'patient_id' => $patient->id,
            'department_id' => $department->id,
            'status' => 'Terdaftar'
        ]);
    }

    public function test_admin_can_view_payment_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('registrations.payment', $this->registration));

        $response->assertStatus(200);
        $response->assertViewIs('registrations.payment');
        $response->assertViewHas('registration', $this->registration);
    }

    public function test_operator_can_view_payment_form()
    {
        $response = $this->actingAs($this->operator)
            ->get(route('registrations.payment', $this->registration));

        $response->assertStatus(200);
        $response->assertViewIs('registrations.payment');
        $response->assertViewHas('registration', $this->registration);
    }

    public function test_admin_can_process_payment()
    {
        $paymentData = [
            'amount' => 100000,
            'payment_method' => 'Tunai',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('registrations.process-payment', $this->registration), $paymentData);

        $response->assertRedirect(route('registrations.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'registration_id' => $this->registration->id,
            'amount' => 100000,
            'payment_method' => 'Tunai',
        ]);

        $this->registration->refresh();
        $this->assertEquals('Lunas', $this->registration->status);
    }

    public function test_operator_can_process_payment()
    {
        $paymentData = [
            'amount' => 100000,
            'payment_method' => 'Kartu Kredit',
        ];

        $response = $this->actingAs($this->operator)
            ->post(route('registrations.process-payment', $this->registration), $paymentData);

        $response->assertRedirect(route('registrations.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('payments', [
            'registration_id' => $this->registration->id,
            'amount' => 100000,
            'payment_method' => 'Kartu Kredit',
        ]);

        $this->registration->refresh();
        $this->assertEquals('Lunas', $this->registration->status);
    }

    public function test_payment_requires_valid_amount()
    {
        $paymentData = [
            'amount' => 'invalid_amount',
            'payment_method' => 'Tunai',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('registrations.process-payment', $this->registration), $paymentData);

        $response->assertSessionHasErrors('amount');
    }

    public function test_payment_requires_valid_payment_method()
    {
        $paymentData = [
            'amount' => 100000,
            'payment_method' => '',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('registrations.process-payment', $this->registration), $paymentData);

        $response->assertSessionHasErrors('payment_method');
    }
}
