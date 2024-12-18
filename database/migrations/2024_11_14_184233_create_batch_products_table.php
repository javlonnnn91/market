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
        Schema::create('batch_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->timestamps();

            $table->index('batch_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_products');
    }
};
