<?php
/**
 * @author Valentine E. Abako <abako220@gmail.com>
 * Date : 05th December, 2017.
 * Time : 08:13am
 * @version 1.0.0
 * 
 * When You are building Something Awesome, You just keep Coding and it get exciting.
 * Building This app to help the less Priviledge and the Priviledge. Not really for Profit. But if there is profit is cool.
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    /**
     * @method createMerchant -- Handles the registration of Merchant info. 
     * @param array $data
     * @return array|mixed
     * 
     */

    public static function merchant_registration($data = [])
    {
        $merchant = new Merchant($data);

        if(!empty($merchant) || !is_null($merchant)){
            //$merchant->
        }
    }

}
