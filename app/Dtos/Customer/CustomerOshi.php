<?php

namespace App\Dtos\Customer;

use App\Dtos\CompanyOshi;

class CustomerOshi
{
  public string $name;
  public string $document;
  public string $email;
  public string $phone;
  public ?string $sku;

  public string $street;
  public string $number;
  public string $neighborhood;
  public string $city;
  public string $state;
  public string $country;

  public CompanyOshi $company;

  public function __construct(object $customer)
  {
    $this->name         = $customer->name;
    $this->document     = $customer->document ?? $customer->cpfCnpj;
    $this->email        = $customer->email;
    $this->phone        = $customer->phone;
    $this->sku          = $customer->id ?? null;

    # Endereco do cliente
    $this->street       = $customer->street ?? $customer->address;
    $this->number       = $customer->number ?? $customer->addressNumber;
    $this->neighborhood = $customer->neighborhood ?? $customer->province;
    $this->city         = $customer->city;
    $this->state        = $customer->state;
    $this->country      = $customer->country ?? 'Brasil';

    # Empresa do cliente
    $this->company = new CompanyOshi($customer);
  }
}
