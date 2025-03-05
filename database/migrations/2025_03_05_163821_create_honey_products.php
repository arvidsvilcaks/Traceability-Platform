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
        Schema::create('honey_products', function (Blueprint $table) {
            $table->primary(['honey_id', 'product_id']);
            $table->unsignedBigInteger('honey_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('honey_id')->references('id')->on('honey')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('honey_products');
    }
};
