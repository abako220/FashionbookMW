<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_merchants', function (Blueprint $table) {
            $table->string('rate_id', 200)->primary();
            $table->integer('rate');
            $table->string('comments', 200);
            $table->string('merchant_id', 100);
            $table->string('customer_id', 200);
            $table->string('full_name', 100);
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
        Schema::drop('rate_merchants');
    }
}
