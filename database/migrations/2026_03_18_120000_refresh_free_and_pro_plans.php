<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('plans')
            ->where('slug', 'free')
            ->update([
                'name' => 'Free',
                'price' => 0,
                'link_limit' => 5,
                'description' => 'Hızlı başlangıç için temel paket.',
            ]);

        DB::table('plans')
            ->where('slug', 'pro')
            ->update([
                'name' => 'Pro',
                'link_limit' => 0,
                'description' => 'Sınırsız link ve premium özellikler.',
            ]);
    }

    public function down(): void
    {
        DB::table('plans')
            ->where('slug', 'free')
            ->update([
                'name' => 'Free',
                'price' => 0,
                'link_limit' => 5,
                'description' => 'Free plan with basic features.',
            ]);

        DB::table('plans')
            ->where('slug', 'pro')
            ->update([
                'name' => 'Pro',
                'link_limit' => 25,
                'description' => 'Pro plan with increased limits.',
            ]);
    }
};
