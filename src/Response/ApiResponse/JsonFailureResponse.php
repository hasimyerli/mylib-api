<?php


namespace App\Response\ApiResponse;

use App\Constant\HttpStatusCode;

class JsonFailureResponse extends ApiJsonResponse
{
    public static function build()
    {
        return new JsonFailureResponse(HttpStatusCode::INTERNAL_SERVER_ERROR);
    }

    public function isSuccess(): bool
    {
       return false;
    }
}