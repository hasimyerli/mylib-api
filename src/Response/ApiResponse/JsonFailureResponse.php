<?php


namespace App\Response\ApiResponse;

use Symfony\Component\HttpFoundation\Response;

class JsonFailureResponse extends ApiJsonResponse
{
    public static function build()
    {
        return new JsonFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function isSuccess(): bool
    {
       return false;
    }
}