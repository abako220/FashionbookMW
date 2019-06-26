<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            //$table->increments('id');
            $table->string('merchant_id')->primary();
            $table->string('surname');
            $table->string('firstname');
            $table->string('middle_name');
            $table->string('phone')->unique();
            $table->string('contact_no')->unique();
            $table->string('email_address')->unique();
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
        Schema::drop('merchants');
    }
}
