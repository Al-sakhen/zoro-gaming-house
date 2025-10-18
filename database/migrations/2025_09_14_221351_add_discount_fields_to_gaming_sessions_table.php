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
            $table->decimal('discount_amount', 10, 2)->default(0)->after('is_active');
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('discount_amount');
            $table->decimal('final_total', 10, 2)->nullable()->after('discount_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaming_sessions', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'discount_percentage', 'final_total']);
        });
    }
};
