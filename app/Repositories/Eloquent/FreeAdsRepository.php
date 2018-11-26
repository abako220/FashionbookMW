<?php namespace App\Repositories;
 
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Eloquent\Repository;
 
class FreeAdsRepository implements FreeRepositoryInterface {
 
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Free_ads'; // Free_ads::clas/ 
    }

    /**
     * @param array|Mixed
     * @return postid
     * @method handles post_free_Ads
     */
    public function postFreeAds(array $data){
        if(is_array($data) && sizeof($data) > 1){

            $this->model()->create([
                'fid'=>$data['post_id'],
                'category_id'=>$data['category_id'],
                'product_sub_id'=>$data['sub_category'],
                'title'=>$data['title'],
                'description'=> $data['description'],
                'gender'=>$data['gender'],
                'type'=>$data['type'] ? $data['type'] : '0',
                'brand'=>$data['brand'] ? $data['brand'] : '0',
                'material'=>$data['material'] ? $data['material'] : '0',
                'colour'=>$data['colour'] ? $data['colour'] : '0',
                'price'=>$data['price'],
                'main_material'=>$data['main_material'] ? $data['main_material'] : '0',
                'main_stone'=>$data['main_stone'] ? $data['main_stone'] : '0',
                'upper_material'=>$data['upper_material'] ? $data['upper_material'] : '0',
                'outsole_material'=>$data['outsole_materia'] ? $data['outsole_materia'] : '0',
                'fastening'=>$data['fastening'] ? $data['fastening'] : '0',
                'movement'=>$data['movement'] ? $data['movement'] : '0',
                'display'=>$data['display'] ? $data['display'] : '0',
                'case_material'=>$data['case_material'] ? $data['case_material']: '0',
                'case_colour'=> $data['case_colour'] ? $data['case_colour'] : '0',
                'band_material'=> $data['band_material'] ? $data['band_material'] : '0',
                'band_color'=> $data['band_color'] ? $data['band_color'] : '0',
                'features'=> $data['features'] ? $data['features'] : '0',
                'scent'=>$data['scent'] ? $data['scent'] : '0',
                'formulation'=>$data['formulation'] ? $data['formulation'] : '0',
                'tone'=>$data['tone'] ? $data['tone'] : '0',
                'phone'=>$data['phone'],
                'contact'=> $data['contact_name'],
                'target_area'=> $data['target_area'] ? $data['target_area'] : '0',
                'skin_type'=>$data['skin_type'] ? $data['skin_type'] : '0',
                'benefit'=>$data['benefit'] ? $data['benefit'] : '0',
                'region'=>$data['region'] ? $data['region'] : '0',
                'place'=>$data['place'] ? $data['place'] : '0',
                'age_group'=>$data['age_group'] ? $data['age_group'] : '0',
                'packages'=>$data['packages'] ? $data['packages'] : '0',
                'form'=>$data['form'] ? $data['form'] : '0',
                'equipment'=>$data['equipment'] ? $data['equipment'] : '0',
                'age'=>$data['age'] ? $data['age'] : '0',
                'isnogiatiable'=> $data['isnogiatiable'] ? $data['isnogiatiable'] : 0]);
                
            return $data['post_id'];
        }

    
    }
}