<?php

namespace App\Dtos\Customer;

use App\Dtos\CompanyOshi;
use Illuminate\Support\Facades\Log;

class CustomerOshi
{
  public string $name;
  public string $document;
  public string $email;
  public string $phone;
  public ?string $sku;
  public CompanyOshi $company;

  public function __construct(object $customer)
  {
    $this->name     = $customer->name;
    $this->document = $customer->document ?? $customer->cpfCnpj;
    $this->email    = $customer->email;
    $this->phone    = $customer->phone;
    $this->sku      = $customer->id ?? null;

    $this->company = new CompanyOshi($customer);
  }
}
