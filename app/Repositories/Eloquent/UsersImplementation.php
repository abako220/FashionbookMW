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

    public function exist($email) {
        $res = $this->model->where('email', $email)->first();
        if(!is_null($res)){
            return true;
        }

        return false;
    }

    public function returnUserInfo($email) {
        $res = $this->model->where('email', $email)->first();
        if($res) {
            return $res;
        }
        return [];
    }

    public function changePassword($email,$newPassword){
            $res = $this->returnUserInfo($email);
            if($res) {
                $res->password = $newPassword;
                return $res->save();
            }
            
    }

    public function update($email, array $data) {
        $res = $this->returnUserInfo($email);
        $name = $data['firstname'].' '.$data['lastname']; 
        
        if($res){
            $res->name = $name;
            $res->phone = $data['phoneNumber'];
            $res->save();
            return $res;
        }

        return [];
        
    }
}