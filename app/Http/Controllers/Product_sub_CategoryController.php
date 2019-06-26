<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Contracts\ProductSubCatInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;

class Product_sub_CategoryController extends Controller
{
    protected $model;

     public function __construct(ProductSubCatInterface $model){
        $this->model = $model;
     }

     public function productSubCategoryList(Request $request)
     {
        $id = $request->route('id');
        $res = $this->model->subCategoryList($id);
        if(!empty($res)){
            return $this->sendResponse($res,ResponseMessage::LIST_OF_PRODUCT_SUB_CATEGORY);
        }
           return $this->sendError(ResponseMessage::NO_CONTENT, RespondCode::NO_CONTENT);
     }
}
