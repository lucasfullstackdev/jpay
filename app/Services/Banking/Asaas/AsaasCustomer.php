<?php

namespace App\Services\Banking\Asaas;

use App\Services\Banking\CustomerInterface;
use Illuminate\Support\Facades\Log;

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

  public function __construct(object $customer)
  {
    $this->name        = $customer->name;
    $this->cpfCnpj     = $customer->document ?? $customer->cpfCnpj;
    $this->email       = $customer->email;
    $this->phone       = $customer->phone;
    $this->mobilePhone = $customer->phone;
    $this->sku         = $customer->id ?? null;

    # Dados da emprea
    $this->company       = $customer->company['name'];
    $this->document      = $customer->company['document'];
    $this->addressNumber = $customer->company['number'];
    $this->postalCode    = $customer->company['zipCode'];
  }
}
