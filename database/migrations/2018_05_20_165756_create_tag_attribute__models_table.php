<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagAttributeModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_attribute__models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id');
            $table->integer('product_cat_id');
            $table->integer('sub_category_id');
            $table->string('attribute', 200);
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
        Schema::drop('tag_attribute__models');
    }
}
