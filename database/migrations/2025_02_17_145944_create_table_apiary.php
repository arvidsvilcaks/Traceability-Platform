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
        Schema::create('apiary', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('location');
            $table->string('floral_composition');
            $table->string('specifics_of_environment');
            $table->string('add_visual_materials')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apiary');
    }
};
