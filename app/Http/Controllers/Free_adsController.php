<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Contracts\FreeRepositoryInterface;

class Free_adsController extends Controller
{
    /**
     * @param array $data
     * @description - 
     * @return array
     * */

     protected $free_ads;

     public function __constructor(FreeRepositoryInterface $free_ads){
        $this->free_ads = $free_ads;
     }
    
     protected function validator(array $data)
      {
        return Validator::make($data, [
            'fid' => 'required',
            'category_id' => 'required|max:255',
            'sub_category'=> 'required',
            'title' => 'required|max:755',
            'description'=> 'required|max:999', 
            'price'=>'required|regex:/^\d*(\.\d{1,3})?$/', // to have more than three(3) decimal place change the 3 to 4 or > 4
            'gender'=>'required',
            'phone'=>'required',
            'contact_name'=>'required|min:2',
            'main_image'=>'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
      }

     public function free_ads(array $data)
     {
         $this->validator($data);
         $res = $this->free_ads->free_ads($data);
         if(!empty($res)){
             return response()->json(['status'=>true, 'data'=>$res, 'message'=>'Free Ads successfully Posted']);
         }
            return response()->json(['status'=>false, 'data'=>$res,'message'=> 'unable to create  a Free Post.']);
     }
}
