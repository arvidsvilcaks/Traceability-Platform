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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('beekeeper_id')->nullable()->after('id');
            $table->unsignedBigInteger('laboratory_id')->nullable()->after('id');
            $table->unsignedBigInteger('wholesaler_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('beekeeper_id');
            
            $table->dropColumn('laboratory_id');

            $table->dropColumn('wholesaler_id');

            $table->dropColumn('packaging_id');
        });
    }
};
