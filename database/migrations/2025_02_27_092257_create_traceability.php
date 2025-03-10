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
        Schema::create('traceability', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('dateLaboratory')->nullable();
            $table->string('dateWholesaler')->nullable();
            $table->string('datePackaging')->nullable();
            
            $table->decimal('latitudeLaboratory', 9, 6)->nullable();
            $table->decimal('longitudeLaboratory', 9, 6)->nullable();

            $table->decimal('latitudeWholesaler', 9, 6)->nullable();
            $table->decimal('longitudeWholesaler', 9, 6)->nullable();

            $table->decimal('latitudePackaging', 9, 6)->nullable();
            $table->decimal('longitudePackaging', 9, 6)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traceability');
    }
};
