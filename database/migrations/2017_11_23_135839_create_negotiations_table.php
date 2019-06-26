<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegotiationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->string('nid', 200)->primary();
            $table->string('product_id', 50);
            $table->decimal('amount', 19, 4);
            $table->string('status', 100);
            $table->string('merchant_id', 200);
            $table->string('customer_id', 200);
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
        Schema::drop('negotiations');
    }
}
