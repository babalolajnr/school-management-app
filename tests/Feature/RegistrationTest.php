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
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/register', [
            'firstName' => 'Test User',
            'lastName' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $newUser = User::whereEmail('test@example.com')->first();
        $response->assertRedirect(route('user.index'));
        $this->assertEquals($newUser?->first_name, 'Test User');
    }
}
