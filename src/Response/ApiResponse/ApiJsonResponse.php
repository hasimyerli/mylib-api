<?php


namespace App\Response\ApiResponse;


use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApiJsonResponse
{
    private $statusCode;
    private $code = -1;
    private $message = '';
    private $internalMessage = '';
    private $validations = [];
    private $data = [];

    public function __construct($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public abstract static function build();

    public abstract function isSuccess(): bool;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getInternalMessage(): string
    {
        return $this->internalMessage;
    }

    public function setInternalMessage(string $internalMessage): self
    {
        $this->internalMessage = $internalMessage;
        return $this;
    }

    public function getValidations(): array
    {
        return $this->validations;
    }

    public function setValidations(array $validations): self
    {
        $this->validations = $validations;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getResponse()
    {
        return new JsonResponse([
            'isSuccess' => $this->isSuccess(),
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'internalMessage' => $this->getInternalMessage(),
            'validations' => $this->getValidations(),
            'data' => $this->getData()
        ], $this->getStatusCode());
    }
}