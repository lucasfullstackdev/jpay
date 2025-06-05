<?php

namespace App\Dtos;

class DiscordMessage
{
  public string $content = 'Erro na aplicação!';
  public array $embeds = [];

  public function __construct(
    string $title,
    string $internalMessage,
    $payload = []
  ) {
    $this->embeds[] = [
      'title' => $title,
      'description' => json_encode([
        'internalMessage' => $internalMessage,
        'payload' => $payload,
      ]),
      'color' => 16711680
    ];
  }
}
