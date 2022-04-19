<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a dev user can view notifications
     *
     * @return void
     */
    public function test_dev_user_can_view_notifications()
    {
        $user = User::factory()->create(['is_dev' => true]);
        $response = $this->actingAs($user)->get(route('notification.index'));
        $response->assertStatus(200);
    }
}
