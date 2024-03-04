<?php

namespace App\Services\Signature;

use App\Dtos\Document\DocumentOshi;
use App\Dtos\Document\DocumentSigner;
use App\Dtos\Document\DocumentSignerOshi;
use App\Dtos\Signer\SignerOshi;
use App\Exceptions\RequestException;
use App\Services\Signature\ClickSign\ClickSignApiSign;
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
    } catch (\Throwable $th) {
      throw new RequestException('Erro ao criar o Documento na ClickSign', $th->getMessage(), $clickSignDocument->document);
    }

    // Se o status code for 201, retorna o documento no formato para ser salvado no banco de dados
    $statusCode = $response->getStatusCode();
    if ($statusCode === Response::HTTP_CREATED) {
      $response = json_decode($response->getBody()->getContents(), true);
      $response['customer'] = $clickSignDocument->customer->sku;

      return new DocumentOshi((object) $response);
    }
  }

  public function sendSigner(ClickSignSigner $clickSignSigner)
  {
    $client = new Client();

    try {
      $response = $client->post("$this->host/v1/signers?access_token=$this->token", [
        'json' => ['signer' => $clickSignSigner->signer]
      ]);
    } catch (\Throwable $th) {
      throw new RequestException('Erro ao criar o Signer na ClickSign', $th->getMessage(), $clickSignSigner->signer);
    }

    // Se o status code for 201, retorna o signer no formato para ser salvado no banco de dados
    $statusCode = $response->getStatusCode();
    if ($statusCode === Response::HTTP_CREATED) {
      $response = json_decode($response->getBody()->getContents(), true);
      $response['customer'] = $clickSignSigner->customer;

      return new SignerOshi((object) $response);
    }
  }

  public function addSignerToDocument(DocumentSigner $documentSigner)
  {
    $client = new Client();

    try {
      $response = $client->post("$this->host/v1/lists?access_token=$this->token", [
        'json' => ['list' => $documentSigner->list]
      ]);
    } catch (\Throwable $th) {
      throw new RequestException('Erro ao adicionar o Signer ao Documento na ClickSign', $th->getMessage(), $documentSigner->list);
    }

    // Se o status code for 201, retorna o DocumentSigner no formato para ser salvo no banco de dados
    $statusCode = $response->getStatusCode();
    if ($statusCode === Response::HTTP_CREATED) {
      $response = json_decode($response->getBody()->getContents(), true);
      return new DocumentSignerOshi((object) $response);
    }
  }

  public function sendNotification(ClickSignNotification $documentSigner)
  {
    $client = new Client();

    try {
      $client->post("$this->host/v1/notifications?access_token=$this->token", [
        'json' => $documentSigner
      ]);
    } catch (\Throwable $th) {
      throw new RequestException('Erro ao enviar a notificação para o Signer na ClickSign', $th->getMessage(), $documentSigner);
    }
  }

  public function signDocument(ClickSignApiSign $clickSignApiSign)
  {
    $client = new Client();

    try {
      $client->post("$this->host/v1/sign?access_token=$this->token", [
        'json' => $clickSignApiSign
      ]);
    } catch (\Throwable $th) {
      throw new RequestException('Erro ao assinar o documento na ClickSign', $th->getMessage(), $clickSignApiSign);
    }
  }
}
