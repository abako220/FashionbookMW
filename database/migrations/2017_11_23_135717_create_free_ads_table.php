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
            $table->string('colour', 100);
            $table->string('brand', 100)->default('0');
            $table->string('type', 100)->default('0');
            $table->string('material', 100)->default('0');
            $table->string('closure', 100)->default('0');
            $table->string('style', 150)->default('0');
            $table->integer('size')->default('0');
            $table->string('main_material', 200)->default('0');
            $table->string('main_stone', 100)->default('0');
            $table->string('upper_material', 100)->default('0');
            $table->string('outsole_material', 100)->default('0');
            $table->string('fastening', 100)->default('0');
            $table->string('movement', 100)->default('0');
            $table->string('display', 100)->default('0');
            $table->string('case_material', 100)->default('0');
            $table->string('case_colour', 100)->default('0');
            $table->string('band_material', 100)->default('0');
            $table->string('band_color', 100)->default('0');
            $table->string('features', 100)->default('0');
            $table->string('scent', 100)->default('0');
            $table->string('formulation', 100)->default('0');
            $table->string('volumn', 100)->default('0');
            $table->string('tone', 100)->default('0');
            $table->string('target_area', 100)->default('0');
            $table->string('skin_type', 100)->default('0');
            $table->string('benefit', 100)->default('0');
            $table->string('age_group', 100)->default('0');
            $table->string('packages', 100)->default('0');
            $table->string('form', 100)->default('0');
            $table->string('equipment', 100)->default('0');
            $table->Integer('age')->default(0);
            $table->longtext('description');
            $table->double('price', 11);
            $table->char('isnogiatiable', 1)->default('0');;
            $table->char('can_share_on_facebook',1)->nullable();
            $table->string('main_image', 150);
            $table->string('gender', 9)->nullable();
            $table->string('phone', 16)->nullable();
            $table->string('contact', 150)->nullable();
            $table->string('region', 150)->nullable();
            $table->string('place', 150)->nullable();

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
