<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\LikeProductsInterface;
use App\like_products;
use Illuminate\Support\Facades\DB;


class LikeProductsImpl implements LikeProductsInterface {
 
    protected $model;


    public function __construct(like_products $model)
    {
        $this->model = $model;
    }

    public function checkIfLikedBefore($device_id, $product_id) {
        $res = $this->model->where('product_id', $product_id)->where('device_id', $device_id)->first();
        if(is_null($res)){
            return true;
        }
        return false;
    }

    public function likeProduct(array $data) {

        if($this->checkIfLikedBefore($data['device_id'], $data['product_id'])) {
            $this->model->create([
                'id'=> $data['device_id'].$data['product_id'],
                'product_id' => $data['product_id'],
                'device_id'=> $data['device_id'],
                'device_user_agent' => $data['device_user_agent'],
                'islike'=>$data['like']
            ]);
            return $data['like'];
        }
        $this->model->where('device_id', $data['device_id'])->where('product_id',$data['product_id'])
                            ->update(['islike'=>$data['like']
                             ]);
        return $data['like'];
        
    }

    public function showProductLikes($product_id) {
        $result = array();
        $res = DB::table('like_products')->select(DB::raw('count(product_id) as likes'))
                        ->where('product_id',$product_id)->get();
        return (int)$res[0]->likes;
                        
        
    }

    
}