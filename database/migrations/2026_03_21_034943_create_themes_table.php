<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_approved')->default(false);
            $table->string('preview_image')->nullable();
            $table->json('config_json');
            $table->timestamps();

            $table->index(['is_active', 'is_approved']);
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->foreignId('theme_id')->nullable()->after('theme')->constrained('themes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('theme_id');
        });
        Schema::dropIfExists('themes');
    }
};
