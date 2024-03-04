<?php

namespace App\Services\Log;

use App\Dtos\DiscordMessage;
use GuzzleHttp\Client;

class DiscordService
{
  public function send(DiscordMessage $discordMessage)
  {
    $client = new Client();

    $client->post(env('DISCORD_WEBHOOK_URL'), [
      'headers' => [
        'Content-Type' => 'application/json'
      ],
      'body' => json_encode($discordMessage)
    ]);
  }
}
