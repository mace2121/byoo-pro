<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_previews', function (Blueprint $table) {
            $table->id();
            $table->string('url_hash', 64)->unique();
            $table->text('url');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('favicon')->nullable();
            $table->text('image')->nullable();
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_previews');
    }
};
