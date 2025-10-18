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
        Schema::table('gaming_sessions', function (Blueprint $table) {
            $table->decimal('gaming_price_adjustment', 10, 2)->default(0)->after('final_total');
            $table->decimal('adjusted_gaming_price', 10, 2)->nullable()->after('gaming_price_adjustment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaming_sessions', function (Blueprint $table) {
            $table->dropColumn(['gaming_price_adjustment', 'adjusted_gaming_price']);
        });
    }
};
