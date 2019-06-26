<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Contracts\StateInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;

class StateController extends Controller
{
    protected $model;

     public function __construct(StateInterface $model){
        $this->model = $model;
     }

     public function all(Request $request)
     {
        $res = $this->model->all();
        if(!empty($res)){
            return $this->sendResponse($res,ResponseMessage::LIST_OF_STATE);
        }
           return $this->sendError(ResponseMessage::NO_CONTENT, RespondCode::NO_CONTENT);
     }
}
