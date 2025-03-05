<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('products', 'honey');
    }

    public function down()
    {
        Schema::rename('honey', 'products');
    }
};
