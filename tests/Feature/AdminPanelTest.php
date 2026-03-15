<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Yönetici Paneli');
    }

    public function test_admin_can_view_users_list()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['username' => 'testuser']);
        
        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee($user->username);
    }
    
    public function test_admin_can_toggle_user_status()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_active' => true]);
        
        $response = $this->actingAs($admin)->patch("/admin/users/{$user->id}/toggle");
        
        $response->assertRedirect();
        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_deactivated_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
