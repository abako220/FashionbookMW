<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class Free_adsController extends Controller
{
    /**
     * @param array $data
     * @description - 
     * @return array
     * */
    
     protected function validator(array $data)
      {
        return Validator::make($data, [
            'category_id' => 'required|max:255',
            'category_id' => 'required',
            'product_sub_id'=> 'required',
            'title' => 'required|max:755',
            'description'=> 'required|max:999', 
            'price'=> 'required|regex:/^\d*(\.\d{1,3})?$/', // to have more than three(3) decimal place change the 3 to 4 or > 4
            'isnogiatiable'=> 'required',
            'main_image'=> 'required',
            ''
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
      }

     public function free_ads(array $data)
     {
         $this->validator($data);
         return Free_ads::create[
             'fid'=>session_id(),
             'category_id'=> $data['category_id'],
             'product_sub_id'=> $data['product_sub_id'],
             'title'=> $data['title'],
             'description'=> $data['description'],
             'price' => doubleVal($data['price']),
             'isnogiatiable'=> $data['isnogiatiable'],
             'main_image'=> $data['main_image'],
             'type'=> $data['type'],
             'size'=> $data['size'] ? $data['size'] : null,
             'color'=> $data['color'] ? $data['color'] : null,
             'phone'=> $data['phone'],
             'region'=> $data['region'],
             'place'=> $data['place'],
             'image_1'=> $data['image_1'] ? $data['image_1'] : null,
             'image_2'=> $data['image_2'] ? $data['image_2'] : null,
             'image_3'=> $data['image_3'] ? $data['image_3'] : null,
             'image_4'=> $data['image_4'] ? $data['image_4'] : null,
             'image_5'=> $data['image_5'] ? $data['image_5'] : null,
             'image_6'=> $data['image_6'] ? $data['image_6'] : null,
             'image_7'=> $data['image_7'] ? $data['image_7'] : null,
             'image_8'=> $data['image_8'] ? $data['image_8'] : null

         ]
     }
}
