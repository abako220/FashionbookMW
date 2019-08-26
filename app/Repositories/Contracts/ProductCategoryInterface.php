<?php
namespace App\Repositories\Contracts;

interface ProductCategoryInterface {
    public function categoryList();
    public function category($id);
}