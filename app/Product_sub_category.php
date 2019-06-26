<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_sub_category extends Model
{
    protected $timestamp = true;
    protected $table='product_sub_categories';
    protected $fillable = [
        'product_cat_id','product_cat_name'
    ];

    protected $date = ['created_at', 'updated_at'];
}
