<?php

namespace App\Services\Signature;

use App\Dtos\Document\DocumentOshi;
use App\Dtos\Document\DocumentSigner;
use App\Dtos\Document\DocumentSignerOshi;
use App\Dtos\Signer\SignerOshi;
use App\Services\Signature\ClickSign\ClickSignDocument;
use App\Services\Signature\ClickSign\ClickSignNotification;
use App\Services\Signature\ClickSign\ClickSignSigner;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class SignatureService
{
  private string $template;
  private string $token;
  private string $host;

  public function __construct()
  {
    $this->host = env('CLICKSIGN_URL');
    $this->template = env('CLICKSIGN_DOCUMENT_TEMPLATE');
    $this->token = env('CLICKSIGN_TOKEN');
  }

  public function sendDocument(ClickSignDocument $clickSignDocument)
  {
    $client = new Client();

    try {
      $response = $client->post("$this->host/v2/templates/$this->template/documents?access_token=$this->token", [
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

  public function sendSigner(ClickSignSigner $clickSignSigner)
  {
    $client = new Client();

    // dd($clickSignSigner->signer);
    try {
      $response = $client->post("$this->host/v1/signers?access_token=$this->token", [
        'json' => ['signer' => $clickSignSigner->signer]
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === Response::HTTP_CREATED) {
        $response = json_decode($response->getBody()->getContents(), true);
        $response['customer'] = $clickSignSigner->customer;

        return new SignerOshi((object) $response);
      }
    } catch (\Throwable $th) {
      dd($th->getMessage());
    }
  }

  public function addSignerToDocument(DocumentSigner $documentSigner)
  {
    $client = new Client();

    try {
      $response = $client->post("$this->host/v1/lists?access_token=$this->token", [
        'json' => ['list' => $documentSigner->list]
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === Response::HTTP_CREATED) {
        $response = json_decode($response->getBody()->getContents(), true);

        return new DocumentSignerOshi((object) $response);
      }

      dd($statusCode, $response);
    } catch (\Throwable $th) {
      dd($th->getMessage());
    }
  }

  public function sendNotification(ClickSignNotification $documentSigner)
  {
    $client = new Client();

    try {
      $response = $client->post("$this->host/v1/notifications?access_token=$this->token", [
        'json' => $documentSigner
      ]);

      $statusCode = $response->getStatusCode();

      if ($statusCode === Response::HTTP_CREATED) {
        $response = json_decode($response->getBody()->getContents(), true);
        // return new DocumentSignerOshi((object) $response);
      }

      dd($statusCode, $response);
    } catch (\Throwable $th) {
      dd($th->getMessage());
    }
  }
}
