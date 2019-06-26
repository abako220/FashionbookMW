<?php
namespace App\Repositories\Contracts;

interface FreeRepositoryInterface {

    public function postFreeAds(array $data);
    public function all($limit,$active);
    public function findOneAndRelatedPost($id);
}