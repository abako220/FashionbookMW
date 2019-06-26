<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Free_ads extends Model
{
    protected $timestamp = true;
    public $incrementing = false;
    public $primaryKey = 'fid';
    protected $fillable = [
        'fid','category_id','product_sub_id','title','description','gender','type','brand','material','colour','price',
        'merchant_id','seller_address','business_name','isnogiatiable','fastening','movement','display','case_material',
        'case_colour','band_material','band_color','features','scent','formulation','tone','phone','contact','target_area',
        'skin_type','benefit','region','place','age_group','packages','active','equipment','age','main_image'
    ];

    public function images(){
        return $this->hasMany('App\Product_Images', 'post_id','fid');
    }
    
}
