<?php


namespace App\EventListener;


use App\Response\ApiResponse\JsonFailureResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    private $jsonFailureResponse;

    public function __construct(JsonFailureResponse $jsonFailureResponse, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->jsonFailureResponse = $jsonFailureResponse;
        $statusCode = $jsonFailureResponse->getStatusCode();
        $message = $jsonFailureResponse->getMessage();
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
    public function getJsonFailureResponse()
    {
        return $this->jsonFailureResponse;
    }
}