<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaasPlansTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithPlan(string $planSlug = 'free', int $linkLimit = 5): User
    {
        $plan = Plan::create([
            'name' => ucfirst($planSlug),
            'slug' => $planSlug,
            'price' => 0,
            'link_limit' => $linkLimit,
        ]);

        $user = User::factory()->create();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
        ]);

        return $user;
    }

    public function test_user_can_create_links_within_limit()
    {
        $user = $this->createUserWithPlan('free', 5);

        $response = $this->actingAs($user)->post('/links', [
            'title' => 'Test Link',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('links', ['user_id' => $user->id, 'title' => 'Test Link']);
    }

    public function test_user_cannot_exceed_link_limit()
    {
        $user = $this->createUserWithPlan('free', 2);

        // Create 2 links to fill the limit
        for ($i = 1; $i <= 2; $i++) {
            $user->links()->create([
                'title' => "Link {$i}",
                'url' => "https://example{$i}.com",
                'order' => $i,
                'is_active' => true,
            ]);
        }

        // Attempt to create a 3rd link
        $response = $this->actingAs($user)->post('/links', [
            'title' => 'Over Limit Link',
            'url' => 'https://overlimit.com',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('links', ['title' => 'Over Limit Link']);
    }

    public function test_pricing_page_shows_plans()
    {
        $user = $this->createUserWithPlan('free', 5);

        Plan::create(['name' => 'Pro', 'slug' => 'pro', 'price' => 9.99, 'link_limit' => 25]);

        $response = $this->actingAs($user)->get('/pricing');

        $response->assertStatus(200);
        $response->assertSee('Free');
        $response->assertSee('Pro');
    }
}
