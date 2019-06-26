<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\Utility\ResponseMessage;
use App\Utility\ResponseCode;

class Product_CategoryController extends Controller
{
    protected $model;

     public function __construct(ProductCategoryInterface $model){
        $this->model = $model;
     }

     public function productCategoryList(Request $request)
     {
        $res = $this->model->categoryList();
        if(!empty($res)){
            return $this->sendResponse($res,ResponseMessage::LIST_OF_PRODUCT_CATEGORY);
        }
           return $this->sendError(ResponseMessage::NO_CONTENT, RespondCode::NO_CONTENT);
     }
}
