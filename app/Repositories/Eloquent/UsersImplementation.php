<?php

namespace App\Repositories\Eloquent; 
use App\User;
use App\Repositories\Contracts\UsersInterface;

class UsersImplementation implements UsersInterface{

    protected $model;

    function __construct(User $model){
        $this->model = $model;
    }

    public function create($data){
        return $this->model->create($data);
    }
}