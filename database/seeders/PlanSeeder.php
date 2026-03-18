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
        Plan::updateOrCreate(['slug' => 'free'], [
            'name' => 'Free',
            'slug' => 'free',
            'price' => 0,
            'link_limit' => 5,
            'description' => 'Hızlı başlangıç için temel paket.',
        ]);

        Plan::updateOrCreate(['slug' => 'pro'], [
            'name' => 'Pro',
            'slug' => 'pro',
            'price' => 9.99,
            'link_limit' => 0,
            'description' => 'Sınırsız link ve premium özellikler.',
        ]);

        Plan::updateOrCreate(['slug' => 'business'], [
            'name' => 'Business',
            'slug' => 'business',
            'price' => 29.99,
            'link_limit' => 100,
            'description' => 'Business plan for power users.',
        ]);
    }
}
