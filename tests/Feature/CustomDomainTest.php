<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_is_served_via_verified_custom_domain(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'custom_domain' => 'my.link.com',
            'custom_domain_verified' => true,
            'is_active' => true,
        ]);

        $response = $this->get('http://my.link.com/');

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertViewIs('public.profile');
    }

    public function test_profile_is_not_served_if_custom_domain_is_not_verified(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'custom_domain' => 'unverified.com',
            'custom_domain_verified' => false,
            'is_active' => true,
        ]);

        $response = $this->get('http://unverified.com/');

        // If not verified, middleware doesn't set attribute, web.php serves welcome
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertDontSee($user->name);
    }

    public function test_system_domain_still_serves_landing_page(): void
    {
        $response = $this->get('http://localhost/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_custom_domain_can_be_updated_in_profile_settings(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'New Name',
            'username' => $user->username,
            'email' => $user->email,
            'custom_domain' => 'new.domain.com',
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'custom_domain' => 'new.domain.com',
            'custom_domain_verified' => false,
        ]);
    }
}
