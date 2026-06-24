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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cafeteria_item_id')->constrained('cafeteria_items')->onDelete('cascade');
            $table->foreignId('session_id')->nullable()->constrained('gaming_sessions')->nullOnDelete();
            $table->string('movement_type', 50);
            $table->integer('quantity_change');
            $table->integer('quantity_before')->nullable();
            $table->integer('quantity_after')->nullable();
            $table->string('source', 80)->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->index(['cafeteria_item_id', 'created_at']);
            $table->index(['session_id', 'created_at']);
            $table->index('movement_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
