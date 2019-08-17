<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like_products extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamp = true;
    public $table = 'like_products';

    protected $fillable = ['id', 'product_id','device_user_agent','device_id','like'];
}
