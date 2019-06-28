<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\FreeRepositoryInterface;
use App\Utility\Util as util; 
use App\Free_ads;
use App\Product_Images;
use Illuminate\Support\Facades\DB;
 
class FreeAdsRepository implements FreeRepositoryInterface {
 
    protected $model;
    protected $image;
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    

    function __construct(Free_ads $model, Product_Images $product_image){
        $this->model = $model;
        $this->image = $product_image;
    }

    /**
     * @param array|Mixed
     * @return postid
     * @method handles post_free_Ads
     */
    public function postFreeAds(array $data){
        
        if(is_array($data) && sizeof($data) > 1){

            $id = util::generateID();
            $fid = self::checkIfIdExist($id);
            $this->model->create([
                'fid'=>$fid,
                'category_id'=>$data['category_id'],
                'product_sub_id'=>$data['sub_category'],
                'title'=>$data['title'],
                'description'=> $data['description'],
                'gender'=>$data['gender'],
                'type'=>$data['type'] ? $data['type'] : '0',
                'colour'=>$data['colour'] ? $data['colour'] : '0',
                'price'=>$data['price'],
                'phone'=>$data['phone'],
                'contact'=> $data['contact_name'],
                'region'=>$data['region'] ? $data['region'] : '0',
                'place'=>$data['place'] ? $data['place'] : '0',
                'isnogiatiable'=> isset($data['isnegotiable']) ? $data['isnegotiable'] : 0,
                'active'=>1,
                'merchant_id'=> $data['merchant_id'] ? $data['merchant_id'] : null,
                'seller_address'=> $data['seller_address'] ? $data['seller_address'] : null,
                'business_name'=> isset($data['business_name']) ? $data['business_name'] : null,
                'main_image'=> $data['main_image'] ? $data['main_image'] : 'N/A']);
                 
                
            return $fid;
        }
    
    }

        public function checkIfIdExist($id){
            $array_result = array();
            do{
                $id = util::generateID();
        
                $db_value = $this->model->where('fid','=', $id)->first();
        
            if(empty($db_value->fid)){
        
            return $id;
            }
        
            }  while($db_value->fid!= $id);


            return $id;
        }

        public function all($limit,$status){

            $result = DB::table('free_ads')->select('free_ads.*', DB::raw('count(*) as total_item'))
                    ->groupby('product_sub_id')->skip(0)->take($limit)->orderby('product_sub_id')->get();
                    foreach($result as $key=>$value) {
                        $result[$key]->main_image = DB::table('free_ads')->select('free_ads.main_image')->where('product_sub_id',$value->product_sub_id)
                        ->take(3)->get();
                      
                    }
                    return $result;
            
        }

        public function findOneAndRelatedPost($id){
            $post_add ['ads-details']= $this->model->where('fid',$id)->first();
            $product_sub_category_id = $post_add ['ads-details']['product_sub_id'];
            if(isset($post_add) && !empty($post_add) && !is_null($post_add)){
                $post_add ['ads-images'] = $this->image->where('post_id', 'like', '%'.$id.'%')->get();
                $post_add['similar_ads'] = DB::table('free_ads')->join('product_images','product_images.post_id','=','free_ads.fid')
                ->where('free_ads.product_sub_id',$product_sub_category_id)
                ->select(DB::raw('count(free_ads.product_sub_id) as image_count, free_ads.*, product_images.path as main_image'))->paginate(50);


                return $post_add;
            }
            

        }



}