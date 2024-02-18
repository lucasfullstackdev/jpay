<?php

namespace App\Dtos\Signer;

class SignerOshi
{
  public string $customer;
  public string $signer_id;
  public string $signer;

  public function __construct(object $response)
  {
    $this->customer = $response->customer;
    $this->signer_id = $response->signer['key'];
    $this->signer = json_encode($response->signer);
  }
}
