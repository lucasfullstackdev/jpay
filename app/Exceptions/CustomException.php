<?php

namespace App\Exceptions;

use App\Dtos\DiscordMessage;
use App\Jobs\SendErrorToDiscordJob;
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

    // Todo erro mapeado será enviado para o Discord
    SendErrorToDiscordJob::dispatch(
      new DiscordMessage($this->message, $this->internalMessage)
    );
  }
}
