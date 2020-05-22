<?php


namespace App\Response\ApiResponse;


use App\Constant\HttpStatusCode;

class JsonSuccessResponse extends ApiJsonResponse
{
    public static function build()
    {
        return new JsonSuccessResponse(HttpStatusCode::OK);
    }

    public function isSuccess(): bool
    {
        return true;
    }
}