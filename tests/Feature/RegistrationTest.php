<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/register', [
            'first_name' => 'Test User',
            'last_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $newUser = User::whereEmail('test@example.com')->first();
        $response->assertRedirect(route('user.index'));
        $this->assertEquals($newUser?->first_name, 'Test User');
    }
}
