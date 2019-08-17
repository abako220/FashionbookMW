<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_products', function (Blueprint $table) {
            $table->string('id', 250)->primary();
            $table->string('product_id', 200);
            $table->string('device_user_agent', 200);
            $table->string('device_id', 200);
            $table->char('islike', 1);
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
        Schema::drop('like_products');
    }
}
