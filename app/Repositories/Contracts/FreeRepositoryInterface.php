<?php
namespace App\Repositories\Contracts;

interface FreeRepositoryInterface {

    public function postFreeAds(array $data);
    public function all($limit,$active);
    public function findOneAndRelatedPost($id,$limit, $status);
    public function viewProductSubCategoryItemAndRelatedCategory($limit,$status,$sub_cat_id,$sort);
    public function similarSubCategoryItemsAndSimilarCategory($catId, $status,$limit, $sort);
    public function getAllSimilarCategory($cat, $limit, $status,$sort);
    public function updateImage ($data = array());
    public function checkIfProductExist($product_id);
    public function searchProduct($title);
    public function updateFreePostAds($merchant_id, $data);
    public function listMerchantFreeAds($merchant_id);
}