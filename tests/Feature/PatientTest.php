<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientTest extends TestCase
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

    public function test_admin_can_view_patients_list()
    {
        $response = $this->actingAs($this->admin)->get(route('patients.index'));
        $response->assertStatus(200);
        $response->assertViewIs('patients.index');
    }

    public function test_operator_cannot_view_patients_list()
    {
        $response = $this->actingAs($this->operator)->get(route('patients.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_create_patient()
    {
        $patientData = Patient::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->post(route('patients.store'), $patientData);

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseHas('patients', ['nik' => $patientData['nik']]);
    }

    public function test_admin_can_update_patient()
    {
        $patient = Patient::factory()->create();
        $updatedData = Patient::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->put(route('patients.update', $patient), $updatedData);

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'name' => $updatedData['name']]);
    }

    public function test_admin_can_delete_patient()
    {
        $patient = Patient::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('patients.destroy', $patient));

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }
}
