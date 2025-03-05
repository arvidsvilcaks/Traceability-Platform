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
        Schema::table('apiary', function (Blueprint $table) {
            $table->renameColumn('product_id', 'honey_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apiary', function (Blueprint $table) {
            $table->renameColumn('honey_id', 'product_id');
        });
    }
};
