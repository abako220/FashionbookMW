<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Contracts\LgaInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;

class LgaController extends Controller
{
    protected $model;

     public function __construct(LgaInterface $model){
        $this->model = $model;
     }

     public function lga(Request $request)
     {
        $id = $request->route('id');
        $res = $this->model->lga($id);
        if(!empty($res)){
            return $this->sendResponse($res,ResponseMessage::LIST_OF_LGA);
        }
           return $this->sendError(ResponseMessage::NO_CONTENT, RespondCode::NO_CONTENT);
     }
}
