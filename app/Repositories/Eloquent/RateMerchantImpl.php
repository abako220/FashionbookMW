<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\RateMerchantInterface;
use App\Rate_merchant;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;

class RateMerchantImpl implements RateMerchantInterface {
 
    protected $model;


    public function __construct(Rate_merchant $model)
    {
        $this->model = $model;
    }

    public function rateMerchant(array $data) {
        if($this->HasCustomerRateSameMerchant($data)){
            return $this->model->create([
                        'rate_id' => $data['customer_id'].$data['merchant_id'],
                        'rate' => $data['rate'],
                        'comments' => $data['comment'],
                        'merchant_id' => $data['merchant_id'],
                        'customer_id' => $data['customer_id'],
                        'full_name' => $data['full_name']
            ]);
                
        }
        return false;
    }

    function HasCustomerRateSameMerchant(array $data){

        $result = $this->model->where('customer_id', $data['customer_id'])
                                ->where('merchant_id', $data['merchant_id'])
                                ->first();
                                
                if(is_null($result)){

                    return true;
                }

        return false;
    }

    function showRating($merchant_id) {
        
        $result = array();
        $res = DB::table('rate_merchants')->select(DB::raw('SUM(rate)/count(*) as rating'))
                        ->where('merchant_id',$merchant_id)->get();
                        $result['avg_rating'] = (int)$res[0]->rating;
                        
        $result['reviews'] = $this->model->where('merchant_id', $merchant_id)->get();
        return $result;
        
    }



}