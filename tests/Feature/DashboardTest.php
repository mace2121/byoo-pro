<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_correct_stats()
    {
        // Setup user
        $user = User::factory()->create();
        
        // Setup profile views
        Profile::create([
            'user_id' => $user->id,
            'username' => 'testuser',
            'views' => 150,
            'is_active' => true,
        ]);

        // Setup links and clicks
        Link::create(['user_id' => $user->id, 'title' => 'Link 1', 'url' => 'example.com/1', 'clicks' => 50, 'is_active' => true]);
        Link::create(['user_id' => $user->id, 'title' => 'Link 2', 'url' => 'example.com/2', 'clicks' => 25, 'is_active' => true]);
        Link::create(['user_id' => $user->id, 'title' => 'Link 3', 'url' => 'example.com/3', 'clicks' => 25, 'is_active' => true]);

        // Act & Assert
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Total Links');
        $response->assertSee('3'); // 3 links
        
        $response->assertSee('Total Clicks');
        $response->assertSee('100'); // 50 + 25 + 25
        
        $response->assertSee('Profile Views');
        $response->assertSee('150'); // profile views
    }
}
