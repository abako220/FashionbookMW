<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Images extends Model
{
    //
    protected $timestamp = true;
    public $incrementing = false;
    public $primaryKey = 'img_id';
   // public $foreignKey = 'post_id';
    public $table = 'product_images';
    protected $fillable = ['img_id', 'merchant_id','path','post_id','store_id'];
}
