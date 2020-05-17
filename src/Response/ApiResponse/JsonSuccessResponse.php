<?php


namespace App\Response\ApiResponse;


class JsonSuccessResponse extends ApiJsonResponse
{
    public static function build()
    {
        return new JsonSuccessResponse();
    }

    public function isSuccess(): bool
    {
        return true;
    }
}