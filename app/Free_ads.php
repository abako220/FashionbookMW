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
        'main_material','main_stone','upper_material','outsole_materia','fastening','movement','display','case_material',
        'case_colour','band_material','band_color','features','scent','formulation','tone','phone','contact','target_area',
        'skin_type','benefit','region','place','age_group','packages','form','equipment','age'
    ];
    
}
