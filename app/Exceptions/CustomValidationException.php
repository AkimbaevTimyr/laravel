<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CustomValidationException extends Exception
{
    protected $exception;


    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /** @var string $exception */
    public function render(): JsonResponse
    {
        return new JsonResponse([
            "message"=> $this->exception->getMessage(),
            'status' => false,
            'code' => $this->exception->getCode(),
            'validationErrors' => $this->exception
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
