<?php


namespace App\Response\ApiResponse;


class JsonFailureResponse extends ApiJsonResponse
{
    public static function build()
    {
        return new JsonFailureResponse();
    }

    public function isSuccess(): bool
    {
       return false;
    }
}