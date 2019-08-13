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

}