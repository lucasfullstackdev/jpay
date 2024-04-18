<?php

namespace App\Services\Banking\Asaas;

use App\Exceptions\CustomerException;
use App\Services\Banking\CustomerInterface;

class AsaasCustomer implements CustomerInterface
{
  public string $name;
  public string $cpfCnpj;
  public string $email;
  public string $phone;
  public string $mobilePhone;
  public ?string $sku;

  public ?string $company;
  public ?string $document;
  public ?string $addressNumber;
  public ?string $postalCode;

  public function __construct(object $purchase)
  {
    try {
      $this->name        = $purchase->customer['name'];
      $this->cpfCnpj     = $purchase->customer['document'] ?? $purchase->cpfCnpj;
      $this->email       = $purchase->customer['email'];
      $this->phone       = $purchase->customer['phone'];
      $this->mobilePhone = $purchase->customer['phone'];
      $this->sku         = $purchase->customer['id'] ?? null;

      # Dados da emprea
      $this->company       = $purchase->company['name'];
      $this->document      = $purchase->company['document'];
      $this->addressNumber = $purchase->company['number'];
      $this->postalCode    = $purchase->company['postal_code'];
    } catch (\Throwable $th) {
      throw new CustomerException('Erro ao criar a estrutura de dados para enviar o Cliente para o ASAAS',  $th->getMessage());
    }
  }
}
