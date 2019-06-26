<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\LgaInterface;
use App\Lga;


class LgaImpl implements LgaInterface {
    protected $model;
    public function __construct(Lga $model) {
        $this->model = $model;

    }

    public function lga($id){
        return $this->model->where('state_id', $id)->get()->toArray();
    }
}