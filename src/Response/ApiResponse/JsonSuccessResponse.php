<?php


namespace App\Response\ApiResponse;

use Symfony\Component\HttpFoundation\Response;

class JsonSuccessResponse extends ApiJsonResponse
{
    public static function build()
    {
        return new JsonSuccessResponse(Response::HTTP_OK);
    }

    public function isSuccess(): bool
    {
        return true;
    }
}