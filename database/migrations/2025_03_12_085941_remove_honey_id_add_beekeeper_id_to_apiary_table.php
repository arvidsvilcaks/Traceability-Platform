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
            $table->dropColumn('honey_id');

            $table->unsignedBigInteger('beekeeper_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apiary', function (Blueprint $table) {
            $table->string('honey_id')->nullable()->after('id');

            $table->dropColumn('beekeeper_id');
        });
    }
};
