<?php
namespace App\Repositories\Contracts;

interface RateMerchantInterface {
    public function rateMerchant(array $data);
    function HasCustomerRateSameMerchant(array $data);
    function showRating($merchant_id);
}