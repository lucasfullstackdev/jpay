<?php

namespace App\Dtos\Document;

use App\Enums\SignerAs;
use App\Models\Document;
use App\Models\OfficeSigner;
use App\Models\Signer;

class DocumentSigner
{
  public array $list;

  public function __construct(Document $document, Signer|OfficeSigner $signer)
  {
    $this->list = [
      'document_key' => $document->document_id,
      'signer_key' => $signer->signer_id,
      'sign_as' => $signer->sign_as ?? SignerAs::SIGN->value,
      'refusable' => false,
    ];
  }
}
