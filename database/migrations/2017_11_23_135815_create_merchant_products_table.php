<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_products', function (Blueprint $table) {
            $table->string('sku',200)->primary();
            $table->string('name',255);
            $table->decimal('price', 19, 4);
            $table->string('merchant_id', 200);
            $table->string('store_id',215);
            $table->string('tax_class',15);
            $table->integer('quantity');
            $table->string('weight',67);
            $table->string('product_cat_id',150);
            $table->string('product_sub_id', 150);
            $table->longText('description');
            $table->string('color',150);
            $table->integer('size');
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
        Schema::drop('merchant_products');
    }
}
