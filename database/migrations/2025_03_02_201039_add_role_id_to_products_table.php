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
        
            $table->foreign('beekeeper_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('laboratory_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wholesaler_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['beekeeper_id']);
            $table->dropColumn('beekeeper_id');
            
            $table->dropForeign(['laboratory_id']);
            $table->dropColumn('laboratory_id');

            $table->dropForeign(['wholesaler_id']);
            $table->dropColumn('wholesaler_id');

            $table->dropForeign(['packaging_id']);
            $table->dropColumn('packaging_id');
        });
    }
};
