<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class RequestException extends CustomException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(protected $message, protected string $internalMessage = '', protected array $payload = [])
    {
        parent::__construct($message, $internalMessage, $payload);
    }
}
