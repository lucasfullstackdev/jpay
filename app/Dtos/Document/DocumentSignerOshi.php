<?php

namespace App\Dtos\Document;

use App\Exceptions\DocumentSignerException;

class DocumentSignerOshi
{
  public string $key;
  public string $request_signature_key;
  public string $document;
  public string $signer;
  public string $sign_as;
  public bool $refusable;
  public string $created_at;
  public string $updated_at;
  public string $url;

  public function __construct(object $response)
  {
    try {
      $this->key = $response->list['key'];
      $this->request_signature_key = $response->list['request_signature_key'];
      $this->document = $response->list['document_key'];
      $this->signer = $response->list['signer_key'];
      $this->sign_as = $response->list['sign_as'];
      $this->refusable = $response->list['refusable'];
      $this->created_at = $response->list['created_at'];
      $this->updated_at = $response->list['updated_at'];
      $this->url = $response->list['url'];
    } catch (\Throwable $th) {
      throw new DocumentSignerException('Erro ao criar estrutura que será utilizada para salvar o DocumentSigner no Banco de Dados', $th->getMessage());
    }
  }
}
