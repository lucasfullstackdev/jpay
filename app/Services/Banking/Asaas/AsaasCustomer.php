<?php

namespace App\Services\Banking\Asaas;

use App\Services\Banking\CustomerInterface;

class AsaasCustomer implements CustomerInterface
{
  public string $name;
  public string $cpfCnpj;
  public string $email;
  public string $phone;
  public ?string $sku;

  public function __construct(object $customer)
  {
    $this->name    = $customer->name;
    $this->cpfCnpj = $customer->document ?? $customer->cpfCnpj;
    $this->email   = $customer->email;
    $this->phone   = $customer->phone;
    $this->sku     = $customer->id ?? null;
  }
}
