<?php

namespace App\Utility;

class ResponseMessage{
    const SUCCESS_STATUS = true;
    const FAILURE_STATUS = false;
    const SUCCESS_POST_MESSAGE = 'Free Ads successfully Posted';
    const FAILURE_POST_MESSAGE = 'unable to create  a Free Post.';
    const BAD_REQUEST = 'A bad request was sent';
    const NO_CONTENT = 'No Content';
    const LIST_OF_PRODUCT_CATEGORY = 'List of Product Category(s)';
    const LIST_OF_PRODUCT_SUB_CATEGORY = 'List of Product Sub Category(s)';
    const LIST_OF_STATE = 'List of states';
    const LIST_OF_LGA = 'List of Lga';
    const INVALID_FILE_FORMAT = "Invalid file Format";
    const MERCHANT_RATING_RESPONSE = 'Merchant successfully rated';
    const CUSTOMER_ALREADY_RATE_MERCHANT = 'You have already rate this merchant';
    const MERCHANT_RATING_INFO = 'Merchant rating info';
    const PRODUCT_SUCCESSFULLY_LIKED = 'Product successfully Liked';
    const CUSTOMER_UNLIKE_PRODUCT = 'Product successful unlike';
    const PRODUCT_LIKE_INFO = 'Product like info';
    const PASSWORD_ERROR = 'Your current password does not match with your old password you provided';
    const PASSWORD_MUST_BE_DIFFERENT = 'Your new Password must be different from your old Password';
    const PASSWORD_CHANGED = 'Password successfully updated';
    const USER_DOES_NOT_EXIST = 'User does not exist';
    const USER_INFO_UPDATED = 'User Profile Successfully updated';
    const FREE_POST_UPDATED = 'Post successfully updated';

}