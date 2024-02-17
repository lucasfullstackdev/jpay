<?php

namespace App\Dtos;

use Illuminate\Support\Facades\Log;

class CompanyOshi
{
  public ?string $name;
  public ?string $document;
  public ?string $street;
  public ?string $number;
  public ?string $neighborhood;
  public ?string $postal_code;
  public ?string $city;
  public ?string $state;
  public ?string $country;
  public ?string $owner_id;

  public function __construct(object $customer)
  {
    $this->name          = $customer->company['name']         ?? $customer->company       ?? null;
    $this->document      = $customer->company['document']     ?? $customer->document      ?? null;
    $this->street        = $customer->company['street']       ?? null;
    $this->number        = $customer->company['number']       ?? null;
    $this->neighborhood  = $customer->company['neighborhood'] ?? null;
    $this->postal_code   = $customer->company['zipCode']      ?? null;
    $this->city          = $customer->company['city']         ?? null;
    $this->state         = $customer->company['state']        ?? null;
    $this->country       = $customer->company['country']      ?? null;
  }
}
