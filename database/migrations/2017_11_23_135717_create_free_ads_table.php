<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_ads', function (Blueprint $table) {
            $table->string('fid', 200)->primary();
            $table->integer('category_id');
            $table->integer('product_sub_id');
            $table->string('title', 20);
            $table->longtext('description');
            $table->double('price', 11);
            $table->char('isnogiatiable', 1);
            $table->char('can_share_on_facebook',1)->nullable();
            $table->string('main_image', 50);
            $table->string('image_1', 50)->nullable();
            $table->string('image_2', 50)->nullable();
            $table->string('image_3', 50)->nullable();
            $table->string('image_4', 50)->nullable();
            $table->string('image_5', 50)->nullable();
            $table->string('image_6', 50)->nullable();
            $table->string('image_7', 50)->nullable();
            $table->string('image_8', 50)->nullable();

            //sub_category
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
        Schema::drop('free_ads');
    }
}
