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
        Schema::table('final_orders', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'discount_percentage', 'final_price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_orders', function (Blueprint $table) {
            $table->decimal('discount_amount', 8, 2)->default(0)->after('total_price');
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('discount_amount');
            $table->decimal('final_price', 8, 2)->default(0)->after('discount_percentage');
        });
    }
};
