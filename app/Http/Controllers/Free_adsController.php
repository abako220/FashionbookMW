<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\FreeRepositoryInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class Free_adsController extends Controller
{
    /**
     * @param array $data
     * @description - 
     * @return array
     * */

     protected $ads;

     public function __construct(FreeRepositoryInterface $ads){
        $this->ads = $ads;
     }

     protected function validator(array $data){
         $validator = Validator::make($data,[
            'category_id' => 'bail|required|max:255',
            'sub_category'=> 'bail|required',
            'title' => 'bail|required|max:755',
            'description'=> 'bail|required|max:999', 
            'price'=>'bail|required|regex:/^\d*(\.\d{1,3})?$/', // to have more than three(3) decimal place change the 3 to 4 or > 4
            'gender'=>'bail|required|min:1',
            'phone'=>'bail|required|min:11',
            'colour'=>'bail|required:min:1',
            'region'=>'bail|required|min:1',
            'place'=>'bail|required|min:2',
            'isnogiatiable'=>'bail|required',
            'contact_name'=>'bail|required|min:2',
            'business_name'=>'bail|required|min:2'
         ]);

         if($validator->fails()){
            return response()->json(['status'=>ResponseMessage::FAILURE_STATUS, 'error_message'=>$validator->errors()->all(), 'code'=>ResponseCode::BAD_REQUEST, 'message'=>ResponseMessage::BAD_REQUEST]);
         }
     }

     /**
      * @param Illuminate\Http\Request;
      * @method free_ads - for posting free ads.
      * @return json|array
      */
     public function free_ads(Request $req)
     {
         $data = $req->all();
         $this->validator($data);
         $res = $this->ads->postFreeAds($data);
         if(!empty($res)){
             return $this->sendResponse($res,ResponseMessage::SUCCESS_POST_MESSAGE);
         }
            return $this->sendError(ResponseMessage::FAILURE_POST_MESSAGE, RespondCode::BAD_REQUEST);
     }

     public function all_post_ads(Request $req){
        $response = $this->ads->all($req->get('limit'),$req->get('status'));
        Log::info('List of active ads'. $response);
        if($response){
         return $this->sendResponse($response,'list of posted products');
        }
        Log::error('Error occurred while trying to view all Ads');
         return $this->sendError(ResponseMessage::NO_CONTENT, RespondCode::NO_CONTENT);

     }
     public function getOneAdsAndRelatedAds(Request $req){
        $response = $this->ads->findOneAndRelatedPost($req->route('id'));
        Log::info('Trying to get Information of a single ads'. $req->route('id'));
        if($response){
           return $this->sendResponse($response,[]);
        }
        Log::notice('No content Found for this Ads with the id'.$req->route('id'));
        return $this->sendError(ResponseMessage::NO_CONTENT, RespondCode::NO_CONTENT);
     }
}
