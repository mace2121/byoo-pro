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
        Schema::table('blocks', function (Blueprint $table) {
            $table->unsignedInteger('clicks')->default(0)->after('position');
        });

        Schema::table('click_logs', function (Blueprint $table) {
            $table->foreignId('block_id')->nullable()->after('link_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('clicks');
        });

        Schema::table('click_logs', function (Blueprint $table) {
            $table->dropForeign(['block_id']);
            $table->dropColumn('block_id');
        });
    }
};
