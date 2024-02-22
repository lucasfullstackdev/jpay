<?php

namespace App\Dtos\Document;

use App\Enums\SignerAs;
use App\Models\Document;
use App\Models\Signer;

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
    $this->key = $response->list['key'];
    $this->request_signature_key = $response->list['request_signature_key'];
    $this->document = $response->list['document_key'];
    $this->signer = $response->list['signer_key'];
    $this->sign_as = $response->list['sign_as'];
    $this->refusable = $response->list['refusable'];
    $this->created_at = $response->list['created_at'];
    $this->updated_at = $response->list['updated_at'];
    $this->url = $response->list['url'];
  }
}
