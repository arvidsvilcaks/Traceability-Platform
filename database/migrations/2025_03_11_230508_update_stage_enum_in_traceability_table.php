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
        Schema::table('traceability', function (Blueprint $table) {
            DB::statement("ALTER TABLE traceability MODIFY COLUMN stage ENUM('laboratory', 'wholesaler', 'packaging', 'beekeeper') NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traceability', function (Blueprint $table) {
            DB::statement("ALTER TABLE traceability MODIFY COLUMN stage ENUM('laboratory', 'wholesaler', 'packaging') NULL");
        });
    }
};
