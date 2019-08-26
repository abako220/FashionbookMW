<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\StateInterface;
use App\States;


class StateImpl implements StateInterface {
    protected $model;
    public function __construct(States $model) {
        $this->model = $model;

    }

    public function all(){
        return $this->model->all()->toArray();
    }
    public function getStateById($id) 
    {
        return $this->model->find($id);
    }
}