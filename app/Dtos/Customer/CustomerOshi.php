<?php

namespace App\Dtos\Customer;

use App\Dtos\CompanyOshi;
use App\Exceptions\CustomerException;

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
  public string $postal_code;
  public ?string $complement;

  public CompanyOshi $company;

  public function __construct(object $purchase)
  {
    try {
      $this->name         = $purchase->customer['name']     ?? $purchase->name;
      $this->document     = $purchase->customer['document'] ?? $purchase->cpfCnpj;
      $this->email        = $purchase->customer['email']    ?? $purchase->email;
      $this->phone        = $purchase->customer['phone']    ?? $purchase->phone;
      $this->sku          = $purchase->customer['id']       ?? $purchase->id ?? null;

      # Endereco do cliente
      $this->street       = $purchase->customer['street']       ?? $purchase->address;
      $this->number       = $purchase->customer['number']       ?? $purchase->addressNumber;
      $this->neighborhood = $purchase->customer['neighborhood'] ?? $purchase->province;
      $this->city         = $purchase->customer['city']         ?? $purchase->cityName;
      $this->state        = $purchase->customer['state']        ?? $purchase->state;
      $this->country      = $purchase->customer['country']      ?? $purchase->country ?? 'Brasil';
      $this->postal_code  = $purchase->customer['postal_code']  ?? $purchase->postalCode;
      $this->complement   = $purchase->customer['complement']   ?? null;
    } catch (\Throwable $th) {
      throw new CustomerException('Erro ao criar a estrutura de dados para salvar a o Customer no banco de dados',  $th->getMessage(), (array) $purchase);
    }

    # Empresa do cliente
    /** A Class CompanyOshi terá sua própria tratativa de Excessões */
    $this->company = new CompanyOshi($purchase);
  }
}
