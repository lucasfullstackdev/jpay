<?php

namespace App\Services\Signature\ClickSign;

use App\Models\DocumentSigner;

class ClickSignNotification
{
  public string $request_signature_key;

  public function __construct(DocumentSigner $documentSigner)
  {
    $this->request_signature_key = $documentSigner->request_signature_key;
  }
}
