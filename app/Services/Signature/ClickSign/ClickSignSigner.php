<?php

namespace App\Services\Signature\ClickSign;

use App\Models\Document;

class ClickSignSigner
{

  public array $signer;
  public string $customer;

  public function __construct(Document $document)
  {
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
  }
}
