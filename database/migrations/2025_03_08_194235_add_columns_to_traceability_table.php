<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('traceability', function (Blueprint $table) {
            $table->dropColumn([
                'dateLaboratory',
                'dateWholesaler',
                'datePackaging',
                'latitudeLaboratory',
                'longitudeLaboratory',
                'latitudeWholesaler',
                'longitudeWholesaler',
                'latitudePackaging',
                'longitudePackaging',
                'addressLaboratory',
                'addressWholesaler',
                'addressPackaging'
            ]);

            $table->string('address')->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->enum('stage', ['laboratory', 'wholesaler', 'packaging'])->nullable();
        });
    }

    public function down()
    {
        Schema::table('traceability', function (Blueprint $table) {
            $table->date('dateLaboratory')->nullable();
            $table->date('dateWholesaler')->nullable();
            $table->date('datePackaging')->nullable();
            $table->decimal('latitudeLaboratory', 10, 7)->nullable();
            $table->decimal('longitudeLaboratory', 10, 7)->nullable();
            $table->decimal('latitudeWholesaler', 10, 7)->nullable();
            $table->decimal('longitudeWholesaler', 10, 7)->nullable();
            $table->decimal('latitudePackaging', 10, 7)->nullable();
            $table->decimal('longitudePackaging', 10, 7)->nullable();
            $table->string('addressLaboratory')->nullable();
            $table->string('addressWholesaler')->nullable();
            $table->string('addressPackaging')->nullable();

            $table->dropColumn(['address', 'longitude', 'latitude', 'stage']);
        });
    }
};
