<?php


namespace App\Util;


use App\EventListener\ApiException;
use App\Response\ApiResponse\JsonFailureResponse;

class ExceptionUtil
{
    public static function throwException(JsonFailureResponse $jsonFailureResponse)
    {
        throw new ApiException($jsonFailureResponse);
    }

    public static function throwDefaultException()
    {
        ExceptionUtil::throwException(JsonFailureResponse::build());
    }
}