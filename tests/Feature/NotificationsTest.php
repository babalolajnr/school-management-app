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

    /**
     * Test that a dev user can send notifications
     *
     * @return void
     */
    public function test_dev_user_can_send_notification()
    {
        $user = User::factory()->create(['is_dev' => true]);
        $response = $this->actingAs($user)->post(route('notification.store', [
            'title' => "A notification",
            'message' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                        Magnam, esse non? Veritatis officia optio, vel nulla 
                        laboriosam aliquam est dolorem doloremque similique nihil aliquid 
                        consectetur exercitationem earum impedit accusantium ipsum.',

            'notification-type' => 'App Notification',
            'to' => 'All',
        ]));
        $response->assertStatus(302)->assertSessionHas('success');
    }
}
