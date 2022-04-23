<?php

namespace Tests\Feature;

use App\Models\AcademicSession;
use App\Models\Period;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcademicSessionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_academic_session_index_method()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('academic-session.index'));
        $response->assertStatus(200);
    }

    public function test_academic_session_edit_method()
    {
        $user = User::factory()->create();
        $academicSession = AcademicSession::factory()->create();
        $response = $this->actingAs($user)->get(route('academic-session.edit', ['academicSession' => $academicSession]));
        $response->assertStatus(200);
    }

    public function test_academic_session_update_method()
    {
        $user = User::factory()->create();
        $academicSession = AcademicSession::factory()->create();
        $startDate = now()->toDateString();
        $endDate = date('Y-m-d', strtotime('+1 year', strtotime($startDate)));

        $response = $this->actingAs($user)->patch(route('academic-session.update', ['academicSession' => $academicSession]), [
            'name' => '2024-2025',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $response->assertStatus(302)->assertSessionHas('success')->assertSessionHasNoErrors();
    }

    public function test_academic_session_that_overlaps_another_will_not_save()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $academicSession = AcademicSession::factory()->create();

        $startDate = '2020-01-01';
        $endDate = '2020-01-02';

        AcademicSession::factory()->create([
            'name' => '2022-2023',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $response = $this->actingAs($user)->patch(route('academic-session.update', ['academicSession' => $academicSession]), [
            'name' => '2024-2025',
            'start_date' => '2020-01-02',
            'end_date' =>  '2020-01-03'
        ]);

        $response->assertStatus(302)->assertSessionHas('error');
    }
}
