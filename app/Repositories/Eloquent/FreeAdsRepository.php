<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\FreeRepositoryInterface;
use App\Utility\Util as util; 
use App\Free_ads;
use App\Product_Images;
use Illuminate\Support\Facades\DB;

 
class FreeAdsRepository implements FreeRepositoryInterface {
 
    protected $model;
    protected $service;
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    

    function __construct(Free_ads $model, Product_Images $product_image){
        $this->model = $model;
        $this->service = $product_image;
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
            
            \Cloudder::upload($data['main_image']);
            $cloudinary_response = \Cloudder::getResult(); 
            $main_image_path = $cloudinary_response['url'];
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
                'main_image'=>$main_image_path]);

                //products image fields
                $data['img_id'] = $fid;
                $data['post_id'] = $fid;

               
                $this->updateImage($data);
                 
                
            return $fid;
        }

        
    }

   
    public function updateImage ($data = array()) {
        $i=0;
        foreach($data['other_image'] as $name)
        {
            $i +=1;
            \Cloudder::upload($name);
            $res = \Cloudder::getResult(); 
            $url = $res['url'];
            $this->service->create(['img_id'=>$data['img_id'].$i,
                                        'merchant_id'=> $data['merchant_id'],
                                        'path'=> $url,
                                        'post_id'=> $data['post_id']
                                        ]);
        }

     }


    

        public function checkIfIdExist($id){
            
            do{
                $id = util::generateID();
        
                $db_value = $this->model->where('fid','=', $id)->first();
        
            if(empty($db_value->fid)){
        
            return $id;
            }
        
            }  while($db_value->fid!= $id);


            return $id;
        }

        public function all($limit,$status){ // 1st page/landing page
            $result = DB::table('free_ads')->select('free_ads.*', DB::raw('count(*) as total_item'))
                        ->where('active',$status)->groupby('product_sub_id')->skip(0)->take($limit)->orderby('product_sub_id')->get();
                    foreach($result as $key=>$value) {
                        $result[$key]->other_images = DB::table('free_ads')->select('free_ads.main_image')->where('product_sub_id',$value->product_sub_id)
                        ->where('active', $status)->take($limit)->get();
                      
                    }
                    return $result;
            
        }

        public function getAllSimilarCategory($catId, $limit, $status, $sort) {
            $result = DB::table('free_ads')->where('category_id', $catId)->where('active', $status)
                        ->skip(0)->take($limit)->orderby('created_at', $sort)->get();
                      $image_count = 0;  
                    foreach($result as $key=>$value) {
                        $result[$key]->other_images = DB::table('free_ads')->join('product_images','product_images.post_id','=','free_ads.fid')
                            ->where('free_ads.fid',$value->fid)->select('product_images.*')->get();
                            $image_count = 0;
                            $image_array = $result[$key]->other_images;
                            if(sizeof($image_array) >=1) {
                                foreach($image_array as $val){
                                    $image_count = $image_count+1;
                                    $result[$key]->total_image = $image_count;
    
                                }
                            }
                            $result[$key]->total_image = $image_count;
                            
                        
                    }
                   
                    return $result;
        }

        public function similarSubCategoryItemsAndSimilarCategory($product_sub_id, $status,$limit,$sort) {
            $image_count = 0;
            $result = DB::table('free_ads')->where('product_sub_id', $product_sub_id)->where('active', $status)
                        ->skip(0)->take($limit)->orderby('created_at',$sort)
                        ->get();
                       
                        if(count($result) > 1) {
                            foreach($result as $key=>$value) {
                                $result[$key]->other_images = DB::table('free_ads')->join('product_images','product_images.post_id','=','free_ads.fid')
                                ->where('free_ads.fid',$value->fid)->select('product_images.*')->get();
                                $image_count = 0;
                                $image_array = $result[$key]->other_images;
                                if(sizeof($image_array) >=1) {
                                    foreach($image_array as $val){
                                        $image_count = $image_count+1;
                                        $result[$key]->total_image = $image_count;
        
                                    }
                                }
                                $result[$key]->total_image = $image_count;
                                $newArray['ads'][] =  $result[$key];
                                
                            }

                            $newArray['similar_ads'] = $this->getAllSimilarCategory($result[0]->category_id,$limit,$status, $sort);
                        
                            
                        }else{

                            return [];
                        }
                       
                        return $newArray;            
                    
        }

        public function viewProductSubCategoryItemAndRelatedCategory($limit,$status,$sub_cat_id, $sort) {
            $image_count = 0;
            $result = DB::table('free_ads')->where('product_sub_id', $sub_cat_id)->where('active', $status)
                        ->skip(0)->take($limit)->orderby('created_at',$sort)
                        ->get();
                       
                        if(count($result) > 1) {
                            foreach($result as $key=>$value) {
                                $result[$key]->other_images = DB::table('free_ads')->join('product_images','product_images.post_id','=','free_ads.fid')
                                ->where('free_ads.fid',$value->fid)->select('product_images.*')->get();
                                $image_count = 0;
                                $image_array = $result[$key]->other_images;
                                if(sizeof($image_array) >=1) {
                                    foreach($image_array as $val){
                                        $image_count = $image_count+1;
                                        $result[$key]->total_image = $image_count;
        
                                    }
                                }
                                $result[$key]->total_image = $image_count;
                                $newArray[] =  $result[$key];
                                
                            }
                            return $newArray;
                        }else{
                            return [];
            }
                   
        }

        public function findOneAndRelatedPost($id,$limit, $status){
            $post_add = $this->model->where('fid',$id)->get();
            $product_sub_category_id = $post_add[0]->product_sub_id;
            if(isset($post_add) && !empty($post_add) && !is_null($post_add)){
                $post_add [0]->other_images = $this->service->where('post_id', 'like', '%'.$id.'%')->get();
                $post_add[0]->similar_ads = $this->viewProductSubCategoryItemAndRelatedCategory($limit,$status,$product_sub_category_id, 'asc');
                return $post_add;
        }
        }

        public function checkIfProductExist($product_id){
            $res = $this->model->where('fid', $product_id)->first();
            if(!is_null($res)) {
                return true;
            }
            return false;
        }

        public function searchProduct($title) {
            return $this->model->where('title', 'like', '%'.$title.'%')
                        ->where('active', 1)->paginate(15);
        }

        public function updateFreePostAds($merchant_id, $data) {
            return $this->model->where('merchant_id', $merchant_id)->where('fid',$data['product_id'])->update([
                'title' => $data['title'],
                'colour'=> $data['colour'],
                'type'=> $data['type'],
                'seller_address' => $data['seller_address'],
                'business_name'=> $data['business_name'],
                'description'=> $data['description'],
                'price'=> $data['price'],
                'phone'=> $data['phone'],
                'contact'=> $data['contact'],
                'region'=> $data['region'],
                'place'=> $data['place']
            ]);
        }

        public function listMerchantFreeAds($merchant_id) {
            $image_count = 0;
            $result = DB::table('free_ads')->where('merchant_id', $merchant_id)->where('active', 1)
                        ->orderby('created_at','desc')->paginate(50);
                        if(count($result) > 1) {
                            foreach($result as $key=>$value) {
                                $result[$key]->other_images = DB::table('free_ads')->join('product_images','product_images.post_id','=','free_ads.fid')
                                ->where('free_ads.fid',$value->fid)->select('product_images.*')->get();
                                $image_count = 0;
                                $image_array = $result[$key]->other_images;
                                if(sizeof($image_array) >=1) {
                                    foreach($image_array as $val){
                                        $image_count = $image_count+1;
                                        $result[$key]->total_image = $image_count;
        
                                    }
                                }
                                $result[$key]->total_image = $image_count;
                                $newArray[] =  $result[$key];
                                
                            }
                            return $newArray;
                        }else{
                            return [];
            }
                   
        }
            

}