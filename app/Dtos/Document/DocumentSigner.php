<?php

namespace App\Dtos\Document;

use App\Enums\SignerAs;
use App\Exceptions\DocumentSignerException;
use App\Models\Document;
use App\Models\OfficeSigner;
use App\Models\Signer;

class DocumentSigner
{
  public array $list;

  public function __construct(Document $document, Signer|OfficeSigner $signer)
  {
    try {
      $this->list = [
        'document_key' => $document->document_id,
        'signer_key'   => $signer->signer_id,
        'sign_as'      => $signer->sign_as ?? SignerAs::SIGN->value,
        'refusable'    => false,
      ];
    } catch (\Throwable $th) {
      throw new DocumentSignerException('Erro ao criar estrutura que será utilizada para adicionar o signatário ao documento na ClickSign', $th->getMessage());
    }
  }
}
