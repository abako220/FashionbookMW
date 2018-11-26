<?php
namespace App\Repositories\Contracts;

interface FreeRepositoryInterface {

    public function postFreeProduct(array $data);
    public function list_free_ads($limit, $criteria);
}