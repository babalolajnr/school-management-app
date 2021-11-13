<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\BranchClassroom;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'is_active' => true
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_teachers_can_authenticate_using_the_login_screen()
    {
        $this->withoutExceptionHandling();
        $branch = Branch::factory()->create();
        $classroom = Classroom::factory()->create();
        $classroom->branches()->attach($branch->id);
        $teacher = Teacher::factory()->create(['branch_classroom_id' => BranchClassroom::where('classroom_id', $classroom->id)->first()->id]);

        $response = $this->post(route('teacher.login'), [
            'email' => $teacher->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('teacher');
        $response->assertRedirect(route('classroom.show.branch', ['classroom' => $classroom, 'branch' => $branch]));
    }

    public function test_teacher_can_not_authenticate_with_invalid_password()
    {
        $teacher = Teacher::factory()->create();

        $this->post(route('teacher.login'), [
            'email' => $teacher->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
