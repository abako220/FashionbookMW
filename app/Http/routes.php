<?php
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'v1','middleware'=>'cors'], function () {
        Route::post('register', 'UserController@register');
        Route::post('login', 'UserController@authenticate');
         Route::get('state', 'StateController@all');
        Route::get('state/{id}', 'LgaController@lga');
        

Route::group(['prefix' => 'merchant'], function () {
    Route::get('merchant_rating/{merchant_id}', 'Rate_MerchantController@showRating');
    Route::get('like_product/{product_id}', 'LikeProductController@ViewProductLike');
   

});

Route::group(['prefix' => 'customer'], function () {
            Route::post('rate_merchant', 'Rate_MerchantController@rateMerchant');
            Route::post('like_product', 'LikeProductController@likeProduct');
            //
});
        
Route::group(['prefix' => 'product'], function () {
        Route::post('free-post', 'Free_adsController@free_ads');
        Route::get('category', 
        'Product_CategoryController@productCategoryList');

        Route::get('all-ads', 'Free_adsController@all_post_ads');
            Route::get('view-ads-detail/{id}', 'Free_adsController@getOneAdsAndRelatedAds');
            Route::get('search', 'Free_adsController@searchProduct');

            Route::get('category/{id}', 'Product_sub_CategoryController@productSubCategoryList');
            Route::get('ads-similar-item-list/{subCatId}', 'Free_adsController@similarSubCategoryItemsAndSimilarCategory');
Route::group(['middleware' => ['jwt.verify']], function() {
           // Route::get('all-ads', 'Free_adsController@all_post_ads');
            //Route::get('view-ads-detail/{id}', 'Free_adsController@getOneAdsAndRelatedAds');
            Route::get('merchant/{merchant_id}', 'Free_adsController@listMerchantFreeAds');
            Route::put('merchant/update_ads/{merchant_id}', 'Free_adsController@updateFreePostAds');
            Route::post('changePassword/{email}', 'UserController@changePassword');
            Route::put('update/{email}', 'UserController@update');
            Route::get('merchant_profile/{email}', 'UserController@viewProfile');
//
            
    
        });
        
    });
});



//Route::rollback('',function(){
  //  return response()->json(['status-code'=>'404','status'=> 'Page not found']);
//});