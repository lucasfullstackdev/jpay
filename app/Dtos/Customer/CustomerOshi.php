<?php

namespace App\Dtos\Customer;

class CustomerOshi
{
  public string $name;
  public string $document;
  public string $email;
  public string $phone;
  public string $sku;

  public function __construct(object $customer)
  {
    $this->name     = $customer->name;
    $this->document = $customer->document ?? $customer->cpfCnpj;
    $this->email    = $customer->email;
    $this->phone    = $customer->phone;
    $this->sku      = $customer->id ?? null;
  }
}
