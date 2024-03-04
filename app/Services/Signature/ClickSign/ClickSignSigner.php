<?php

namespace App\Services\Signature\ClickSign;

use App\Exceptions\DocumentException;
use App\Models\Document;

class ClickSignSigner
{
  public array $signer;
  public string $customer;

  public function __construct(Document $document)
  {
    try {
      $this->signer = [
        'name' => $document->owner->name,
        'email' => $document->owner->email,
        'phone_number' => $document->owner->phone,
        'auths' => [
          'email'
        ],
        'delivery' => 'email',
        'communicate_by' => 'email',
        'has_documentation' => false
      ];

      $this->customer = $document->owner->sku;
    } catch (\Throwable $th) {
      throw new DocumentException('Erro ao criar estrutura que será utilizada para enviar o Signer para ClickSign', $th->getMessage());
    }
  }
}
