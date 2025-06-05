<?php

namespace App\Dtos;

use App\Exceptions\CompanyException;

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
  public ?string $complement;
  public ?string $owner_id;

  public function __construct(object $customer)
  {
    try {
      $this->name          = $customer->company['name']         ?? $customer->company  ?? null;
      $this->document      = $customer->company['document']     ?? $customer->document ?? null;
      $this->street        = $customer->company['street']       ?? null;
      $this->number        = $customer->company['number']       ?? null;
      $this->neighborhood  = $customer->company['neighborhood'] ?? null;
      $this->postal_code   = $customer->company['postal_code']  ?? null;
      $this->city          = $customer->company['city']         ?? null;
      $this->state         = $customer->company['state']        ?? null;
      $this->country       = $customer->company['country']      ?? null;
      $this->complement    = $customer->company['complement']   ?? null;
    } catch (\Throwable $th) {
      throw new CompanyException('Erro ao criar a estrutura de dados para salvar a Empresa no banco de dados',  $th->getMessage());
    }
  }
}
