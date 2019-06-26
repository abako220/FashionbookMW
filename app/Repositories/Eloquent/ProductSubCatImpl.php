<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\ProductSubCatInterface;
use App\Product_sub_category;


class ProductSubCatImpl implements ProductSubCatInterface {
    protected $model;
    public function __construct(Product_sub_category $model) {
        $this->model = $model;

    }

    public function subCategoryList($id){
        return $this->model->where('product_cat_id', $id)->get()->toArray();
    }
}