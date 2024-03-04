<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CustomException extends Exception
{
  public function __construct(protected $message = '', protected string $internalMessage = '')
  {
  }

  public function report()
  {
    Log::error('Erro', [
      'message' => $this->message,
      'code' => $this->code,
      'internalMessage' => $this->internalMessage,
    ]);
  }
}
