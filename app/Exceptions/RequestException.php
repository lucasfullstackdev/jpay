<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestException extends CustomException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(protected $message, protected string $internalMessage = '', protected $payload = [])
    {
        parent::__construct($message, $internalMessage);
    }

    public function report()
    {
        Log::error('Erro', [
            'message' => $this->message,
            'code' => $this->code,
            'internalMessage' => $this->internalMessage,
            'payload' => $this->payload,
        ]);
    }
}
