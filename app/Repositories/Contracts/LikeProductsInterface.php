<?php
namespace App\Repositories\Contracts;

interface LikeProductsInterface {
    public function likeProduct(array $data);
    public function checkIfLikedBefore($device_id, $product_id);
    public function showProductLikes($product_id);
}