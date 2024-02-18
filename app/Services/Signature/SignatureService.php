<?php

namespace App\Services\Signature;

use App\Dtos\Document\DocumentOshi;
use App\Services\Signature\ClickSign\ClickSignDocument;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class SignatureService
{
  public function sendDocument(ClickSignDocument $clickSignDocument)
  {
    $client = new Client();
    $host = env('CLICKSIGN_URL');
    $template = env('CLICKSIGN_DOCUMENT_TEMPLATE');
    $token = env('CLICKSIGN_TOKEN');

    try {
      $response = $client->post("$host/v2/templates/$template/documents?access_token=$token", [
        'json' => ['document' => $clickSignDocument->document]
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === Response::HTTP_CREATED) {
        $response = json_decode($response->getBody()->getContents(), true);
        $response['customer'] = $clickSignDocument->customer->sku;

        return new DocumentOshi((object) $response);
      }
    } catch (\Throwable $th) {
      dd($th->getMessage());
    }
  }
}
