<?php 
namespace App\Repositories\Eloquent; 
use App\Repositories\Contracts\FreeRepositoryInterface;
use App\Repositories\Contracts\ProductSubCatInterface;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\Utility\Util as util; 
use App\Free_ads;
use App\Product_Images;
use App\Repositories\Contracts\LgaInterface;
use App\Repositories\Contracts\StateInterface;
use Illuminate\Support\Facades\DB;

 
class FreeAdsRepository implements FreeRepositoryInterface {
 
    protected $model;
    protected $service;
    protected $sub_cat;
    protected $cat;
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    

    function __construct(Free_ads $model, Product_Images $product_image, ProductSubCatInterface $sub_cat, 
    ProductCategoryInterface $cat, StateInterface $state, LgaInterface $lga){
        $this->model = $model;
        $this->service = $product_image;
        $this->sub_cat = $sub_cat;
        $this->cat = $cat;
        $this->state = $state;
        $this->lga = $lga;
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

            \Cloudinary::config(array(

                "cloud_name" => env('CLOUDINARY_CLOUD_NAME'),
            
                "api_key" => env('CLOUDINARY_API_KEY'),
            
                "api_secret" => env('CLOUDINARY_API_SECRET')
            
            ));

            
            $res =  \Cloudinary\Uploader::upload($data['main_image'], array( 
                "eager" => array(
                  array("width" => 115, "height" => 115, "crop" => "pad"),
                  array("width" => 100, "height" => 100, "crop" => "crop")))
            );
            $main_image_path = $res['url'];
            
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
           $res =  \Cloudinary\Uploader::upload($name, array( 
                "eager" => array(
                  array("width" => 115, "height" => 115, "crop" => "pad"),
                  array("width" => 100, "height" => 100, "crop" => "crop")))
            );
            //$res = \Cloudder::getResult(); 
            $url = $res['url'];
            $small_image_url = $res['eager'][0]['url'];
            $this->service->create(['img_id'=>$data['img_id'].$i,
                                        'merchant_id'=> $data['merchant_id'],
                                        'path'=> $url,
                                        'small_size_path'=>$small_image_url,
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
                        ->where('active', $status)->get();
                        $region = $this->state->getStateById((int)$result[$key]->region);
                        $place = $this->lga->getLgaId((int)$result[$key]->place);
                        $result[$key]->region = trim($region->states.','.$place->lga_name); 
                        $result[$key]->place = $place->lga_name;
                      
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
                            $region = $this->state->getStateById((int)$result[$key]->region);
                                $place = $this->lga->getLgaId((int)$result[$key]->place);
                                $result[$key]->region = trim($region->states.','.$place->lga_name); 
                                $result[$key]->place = $place->lga_name;
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
                       
                        if(count($result) >= 1) {
                            $category = $this->sub_cat->subCategoryList($result[0]->category_id);
                            
                            $main_category = $this->cat->category($result[0]->category_id);
                            foreach($result as $key=>$value) {
                                $result[$key]->other_images = DB::table('free_ads')->join('product_images','product_images.post_id','=','free_ads.fid')
                                ->where('free_ads.fid',$value->fid)->select('product_images.*')->get();
                                $region = $this->state->getStateById((int)$result[$key]->region);
                                $place = $this->lga->getLgaId((int)$result[$key]->place);
                                $result[$key]->region = trim($region->states.','.$place->lga_name); 
                                $result[$key]->place = $place->lga_name;
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
                        
                            $newArray['category'] = $category[0];
                            $newArray['main_category'] = $main_category;
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
                $region = $this->state->getStateById((int)$post_add[0]->region);
                $place = $this->lga->getLgaId((int)$post_add[0]->place);
                $post_add [0]->region = trim($region->states.','. $place->lga_name);
                $post_add[0]->place = $place->lga_name;
                $post_add[0]->similar_ads = $this->viewProductSubCategoryItemAndRelatedCategory($limit,$status,$product_sub_category_id, 'asc');
                $post_add[0]['main_category'] = $this->cat->category($post_add[0]->category_id);
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
            $res =  $this->model->where('merchant_id', $merchant_id)->where('fid',$data['product_id'])->first();
            if(!is_null($res)){
                return $res->update([
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

            return [];
            
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