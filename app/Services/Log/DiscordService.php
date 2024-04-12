<?php

namespace App\Services\Log;

use App\Dtos\DiscordMessage;
use GuzzleHttp\Client;

class DiscordService
{
  public function __construct(private string $channel = '')
  {
    if (empty($this->channel)) {
      $this->channel = env('DISCORD_WEBHOOK_URL_APPLICATION_ERRORS');
    }
  }

  public function send(DiscordMessage $discordMessage)
  {
    $client = new Client();

    $client->post($this->channel, [
      'headers' => [
        'Content-Type' => 'application/json'
      ],
      'body' => json_encode($discordMessage)
    ]);
  }
}
