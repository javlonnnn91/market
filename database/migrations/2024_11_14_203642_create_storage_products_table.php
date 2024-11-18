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
        Schema::create('storage_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_id')->constrained('storages');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('batch_id')->constrained('batches');
            $table->integer('quantity');
            $table->timestamps();

            $table->index('storage_id');
            $table->index('product_id');
            $table->index('batch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_products');
    }
};
