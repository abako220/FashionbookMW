<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\RateMerchantInterface;
use App\Repositories\Contracts\UsersInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;


class Rate_MerchantController extends Controller
{
    protected $rate;
    protected $user;

     public function __construct(RateMerchantInterface $rate, UsersInterface $user){
        $this->rate = $rate;
        $this->user = $user;
     }

     protected function validator(array $data){
         $validator = Validator::make($data,[
            'rate' => 'bail|required',
            'comment' => 'bail|required|max:250',
            'merchant_id' =>'required|min:4',
            'customer_id' => 'required|min:5',
            'full_name' => 'required|min:2,max:250'
            ]);

            if($validator->fails()){
                return response()->json(['status'=>ResponseMessage::FAILURE_STATUS, 'error_message'=>$validator->errors()->all(), 'code'=>ResponseCode::BAD_REQUEST, 'message'=>ResponseMessage::BAD_REQUEST]);
             }
         }
    
    public function rateMerchant(Request $request) {
        $data = $request->all();
        $this->validator($data);
        $check = $this->user->exist($data['merchant_id']);
        if($check) {
            $res = $this->rate->rateMerchant($data);
            
            if($res){
                return $this->sendResponse($res,ResponseMessage::MERCHANT_RATING_RESPONSE);
            }
           
                return $this->sendError(ResponseMessage::CUSTOMER_ALREADY_RATE_MERCHANT,ResponseCode::UNAUTHORIZE_USER);
        
        }
        return $this->sendError(ResponseMessage::NO_CONTENT, ResponseCode::NO_CONTENT);

    }

    public function showRating(Request $request) {
        $merchant_id = $request->route('merchant_id');
        $check = $this->user->exist($merchant_id);
        if($check) {
            $res = $this->rate->showRating($merchant_id);
            return $this->sendResponse($res,ResponseMessage::MERCHANT_RATING_INFO);

        }

        return $this->sendError(ResponseMessage::NO_CONTENT, ResponseCode::NO_CONTENT);


    }
    
}
