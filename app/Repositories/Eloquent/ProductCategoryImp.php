<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\ProductCategoryInterface;
use App\Product_category;


class ProductCategoryImp implements ProductCategoryInterface {
    protected $model;
    public function __construct(Product_category $model) {
        $this->model = $model;

    }

    public function categoryList(){
        return $this->model->all();
    }
}