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
    Log::info("passando por aqui.....>>>\n" . json_encode($customer));
    $this->name          = $customer->company['name']         ?? $customer->company       ?? null;
    $this->document      = $customer->company['document']     ?? $customer->document      ?? null;
    $this->street        = $customer->company['street']       ?? $customer->addrees       ?? null;
    $this->number        = $customer->company['number']       ?? $customer->addressNumber ?? null;
    $this->neighborhood  = $customer->company['neighborhood'] ?? $customer->province      ?? null;
    $this->postal_code   = $customer->company['zipCode']      ?? $customer->postalCode    ?? null;
    $this->city          = $customer->company['city']         ?? $customer->city          ?? null;
    $this->state         = $customer->company['state']        ?? $customer->state         ?? null;
    $this->country       = $customer->company['country']      ?? $customer->country       ?? null;
  }
}
