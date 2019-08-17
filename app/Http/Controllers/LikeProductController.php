<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\LikeProductsInterface;
use App\Repositories\Contracts\FreeRepositoryInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;
use App\Http\Requests;

class LikeProductController extends Controller
{
    protected $service;
    protected $free_ads;

    public function __construct(LikeProductsInterface $service, FreeRepositoryInterface $free_ads){
        $this->service = $service;
        $this->free_ads = $free_ads;
       
     }

     protected function validator(array $data){
        $validator = Validator::make($data,[
           'product_id' => 'bail|required',
           'device_user_agent' => 'bail|required|max:250',
           'device_id' => 'required|min:4',
           'like' => 'required|min:1'
           ]);

           if($validator->fails()){
               return response()->json(['status'=>ResponseMessage::FAILURE_STATUS, 'error_message'=>$validator->errors()->all(), 'code'=>ResponseCode::BAD_REQUEST, 'message'=>ResponseMessage::BAD_REQUEST]);
            }
        }

     public function likeProduct(Request $request) {
         $data = $request->all();
         $this->validator($data);
         if($this->free_ads->checkIfProductExist($data['product_id'])){
         $res = $this->service->likeProduct($data);
         if($res == 1){
            return $this->sendResponse($res,ResponseMessage::PRODUCT_SUCCESSFULLY_LIKED);
         }
         return $this->sendResponse($res,ResponseMessage::CUSTOMER_UNLIKE_PRODUCT);
        }
        return $this->sendError(ResponseMessage::NO_CONTENT, ResponseCode::NO_CONTENT);
     }

     public function ViewProductLike(Request $request) {
        $product_id = $request->route('product_id');
        if($this->free_ads->checkIfProductExist($product_id)){
            $res = $this->service->showProductLikes($product_id);
            return $this->sendResponse($res,ResponseMessage::PRODUCT_LIKE_INFO);
        }

        return $this->sendError(ResponseMessage::NO_CONTENT, ResponseCode::NO_CONTENT);
     }
}
