<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->string('store_id', 120);
            $table->string('merchant_id', 200);
            $table->string('storename', 255);
            $table->string('store_address', 255);
            $table->string('phone', 250);
            $table->string('store_type', 90);
            $table->string('store_email', 100);
            $table->integer('store_size', 11);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stores');
    }
}
