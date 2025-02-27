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
        Schema::table('users', function (Blueprint $table) {
                $table->string('surname')->nullable();
                $table->string('company')->nullable();
                $table->enum('role', allowed: ['Beekeeper', 'Packaging company', 'Wholesaler', 'Laboratory employee', 'Beekeeping association', 'Administrator']);
                $table->string('country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('company');
            $table->dropColumn(columns: 'role');
            $table->dropColumn(columns: 'country');
        });
    }
};
