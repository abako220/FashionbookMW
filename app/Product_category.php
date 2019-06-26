<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    protected $timestamp = true;
    protected $table = 'product_categories';
    protected $fillable = [
        'category_name'
    ];

    protected $date = ['created_at', 'updated_at'];
}
