<?php

namespace App\Dtos\Signer;

use App\Exceptions\SignerException;

class SignerOshi
{
  public string $customer;
  public string $signer_id;
  public string $signer;

  public function __construct(object $response)
  {
    try {
      $this->customer  = $response->customer;
      $this->signer_id = $response->signer['key'];
      $this->signer    = json_encode($response->signer);
    } catch (\Throwable $th) {
      throw new SignerException('Erro ao criar estrutura que será utilizada para enviar o Signer para ClickSign', $th->getMessage());
    }
  }
}
