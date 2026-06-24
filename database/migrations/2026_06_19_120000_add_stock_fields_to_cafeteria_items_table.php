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
        Schema::table('cafeteria_items', function (Blueprint $table) {
            $table->string('barcode')->nullable()->unique()->after('name');
            $table->decimal('cost_price', 8, 2)->nullable()->after('price_per_item');
            $table->integer('quantity')->nullable()->after('cost_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cafeteria_items', function (Blueprint $table) {
            $table->dropUnique(['barcode']);
            $table->dropColumn(['barcode', 'cost_price', 'quantity']);
        });
    }
};
