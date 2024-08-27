<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Patient;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $operator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->operator = User::factory()->create(['role' => 'operator']);
    }

    public function test_admin_can_view_registrations_list()
    {
        $response = $this->actingAs($this->admin)->get(route('registrations.index'));
        $response->assertStatus(200);
        $response->assertViewIs('registrations.index');
    }

    public function test_operator_can_view_registrations_list()
    {
        $response = $this->actingAs($this->operator)->get(route('registrations.index'));
        $response->assertStatus(200);
        $response->assertViewIs('registrations.index');
    }

    public function test_admin_can_create_registration()
    {
        $patient = Patient::factory()->create();
        $department = Department::factory()->create();

        $registrationData = [
            'patient_id' => $patient->id,
            'department_id' => $department->id,
            'registration_date' => now()->format('Y-m-d'),
            'status' => 'registered',
        ];

        $response = $this->actingAs($this->admin)->post(route('registrations.store'), $registrationData);

        $response->assertRedirect(route('registrations.index'));
        $this->assertDatabaseHas('registrations', ['patient_id' => $patient->id, 'department_id' => $department->id]);
    }

    public function test_operator_can_create_registration()
    {
        $patient = Patient::factory()->create();
        $department = Department::factory()->create();

        $registrationData = [
            'patient_id' => $patient->id,
            'department_id' => $department->id,
            'registration_date' => now()->format('Y-m-d'),
            'status' => 'registered',
        ];

        $response = $this->actingAs($this->operator)->post(route('registrations.store'), $registrationData);

        $response->assertRedirect(route('registrations.index'));
        $this->assertDatabaseHas('registrations', ['patient_id' => $patient->id, 'department_id' => $department->id]);
    }
}
