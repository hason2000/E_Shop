<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAddressShops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_address_shops', function (Blueprint $table) {
            $table->id();
            $table->string('number', 5);
            $table->string('street', 50);
            $table->string('ward', 50);
            $table->string('city', 50);
            $table->string('province', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_address_shops');
    }
}
