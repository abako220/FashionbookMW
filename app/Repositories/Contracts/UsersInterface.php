<?php

namespace App\Repositories\Contracts;

interface UsersInterface{
    public function create($data);
    public function exist($email);
    public function returnUserInfo($email);
    public function changePassword($email,$newPassword);
    public function update($email, array $data);
    
}