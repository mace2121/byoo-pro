<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('source_link_id')->nullable()->constrained('links')->nullOnDelete();
            $table->string('type')->default('link');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('url')->nullable();
            $table->string('button_type')->nullable();
            $table->text('button_link')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'position']);
            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
