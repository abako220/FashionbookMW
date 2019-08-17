<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate_merchant extends Model
{
    protected $primaryKey = 'rate_id';
    public $incrementing = false;
    public $timestamp = true;
    public $table = 'rate_merchants';
    
    protected $fillable = ['rate_id', 'rate','comments','merchant_id','customer_id','full_name'];

}
