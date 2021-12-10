<?php

namespace Tests\Feature;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuardianTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_guardian_controller_edit_method()
    {
        $user = User::factory()->create();
        $guardian = Guardian::factory()->create();
        $response = $this->actingAs($user)->get(route('guardian.edit', ['guardian' => $guardian]));
        $response->assertStatus(200);
    }

    public function test_guardian_controller_update_method()
    {
        $user = User::factory()->create();
        $guardian = Guardian::factory()->create();

        $response = $this->actingAs($user)->patch(route('guardian.update', ['guardian' => $guardian]), [
            'title' => $this->faker->title(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => 'email@gmail.com',
            'phone' => '09019203939',
            'occupation' => $this->faker->jobTitle(),
            'address' => $this->faker->address()
        ]);

        $response->assertStatus(302)->assertSessionHas('success')->assertSessionHasNoErrors();
    }

    public function test_guardian_can_be_changed()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        $guardian = Guardian::factory()->create();

        $response = $this->actingAs($user)->post(route('guardian.change', ['student' => $student]), [
            'guardian' => $guardian->email
        ]);

        $response->assertStatus(302)->assertSessionHas('success');
    }
}
