<?php
namespace App\Repositories\Contracts;

interface StateInterface {
    public function all();
    public function getStateById($id);
}