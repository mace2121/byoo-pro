<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClickTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_link_redirect_creates_click_log()
    {
        // Setup user, profile and link
        $user = User::factory()->create(['username' => 'testuser']);
        $profile = Profile::create([
            'user_id' => $user->id,
            'username' => 'testuser',
            'is_active' => true,
        ]);
        $link = Link::create([
            'user_id' => $user->id,
            'title' => 'My Link',
            'url' => 'https://example.com',
            'is_active' => true,
        ]);

        // Hit the redirect endpoint with some headers
        $response = $this->withHeaders([
            'User-Agent' => 'Test-Agent',
            'CF-IPCountry' => 'TR',
        ])->get(route('public.redirect', $link));

        // Assert redirect
        $response->assertRedirect('https://example.com');

        // Assert click count incremented
        $this->assertEquals(1, $link->fresh()->clicks);

        // Assert click log created
        $this->assertDatabaseHas('click_logs', [
            'link_id' => $link->id,
            'device' => 'Test-Agent',
            'country' => 'TR',
        ]);
    }
}
