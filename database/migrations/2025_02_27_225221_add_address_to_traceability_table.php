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
            $table->string('addressLaboratory')->nullable();
            $table->string('addressWholesaler')->nullable();
            $table->string('addressPackaging')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('traceability', function (Blueprint $table) {
            $table->dropColumn('addressLaboratory');
            $table->dropColumn('addressWholesaler');
            $table->dropColumn('addressPackaging');
        });
    }
};
