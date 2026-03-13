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
        Schema::table('profiles', function (Blueprint $table) {
            // Theme Type: 'preset' or 'custom'
            $table->string('theme_type')->default('preset')->after('theme');
            
            // Custom Backgrounds
            $table->string('bg_type')->nullable(); // 'color', 'gradient', 'image'
            $table->string('bg_color')->nullable();
            $table->string('bg_image')->nullable();
            $table->integer('bg_blur')->default(0);
            $table->integer('bg_overlay')->default(0);
            
            // Custom Styling
            $table->string('text_color')->nullable();
            $table->string('button_color')->nullable();
            $table->string('button_text_color')->nullable();
            $table->string('button_style')->default('rounded'); // 'rounded', 'pill', 'square', 'soft'
            $table->string('font_family')->default('sans');
            
            // Advanced
            $table->text('custom_css')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'theme_type',
                'bg_type',
                'bg_color',
                'bg_image',
                'bg_blur',
                'bg_overlay',
                'text_color',
                'button_color',
                'button_text_color',
                'button_style',
                'font_family',
                'custom_css'
            ]);
        });
    }
};
