<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'price' => 0,
            'link_limit' => 5,
            'description' => 'Free plan with basic features.',
        ]);

        Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'price' => 9.99,
            'link_limit' => 25,
            'description' => 'Pro plan with increased limits.',
        ]);

        Plan::create([
            'name' => 'Business',
            'slug' => 'business',
            'price' => 29.99,
            'link_limit' => 100,
            'description' => 'Business plan for power users.',
        ]);
    }
}
