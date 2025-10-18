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
        Schema::create('gaming_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('gaming_sessions')->onDelete('cascade');
            $table->foreignId('cafeteria_item_id')->constrained()->onDelete('cascade');
            $table->integer('units_count');
            $table->decimal('price_per_unit', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaming_orders');
    }
};
