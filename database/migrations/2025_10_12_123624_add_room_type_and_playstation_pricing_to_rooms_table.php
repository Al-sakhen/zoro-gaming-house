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
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('type', ['playstation', 'pc', 'tables'])->default('playstation')->after('name');
            $table->decimal('price_per_hour_2_controllers', 8, 2)->nullable()->after('price_per_hour');
            $table->decimal('price_per_hour_4_controllers', 8, 2)->nullable()->after('price_per_hour_2_controllers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['type', 'price_per_hour_2_controllers', 'price_per_hour_4_controllers']);
        });
    }
};
