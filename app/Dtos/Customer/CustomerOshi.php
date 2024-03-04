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

  public function __construct(object $customer)
  {
    try {
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
      $this->postal_code  = $customer->postal_code ?? $customer->postalCode;
      $this->complement   = $customer->complement ?? null;
    } catch (\Throwable $th) {
      throw new CustomerException('Erro ao criar a estrutura de dados para salvar a o Customer no banco de dados',  $th->getMessage());
    }

    # Empresa do cliente
    /** A Class CompanyOshi terá sua própria tratativa de Excessões */
    $this->company = new CompanyOshi($customer);
  }
}
