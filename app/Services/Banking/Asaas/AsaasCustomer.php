<?php

namespace App\Services\Banking\Asaas;

use App\Enums\Person;
use App\Exceptions\CustomerException;
use App\Services\Banking\CustomerInterface;

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

  public function __construct(object $purchase)
  {
    try {
      $this->name        = $purchase->customer['name'];
      $this->cpfCnpj     = $purchase->customer['document'] ?? $purchase->cpfCnpj;
      $this->email       = $purchase->customer['email'];
      $this->phone       = preg_replace('/\D/', '', $purchase->customer['phone']);
      $this->mobilePhone = preg_replace('/\D/', '', $purchase->customer['phone']);
      $this->sku         = $purchase->customer['id'] ?? null;

      /* Se o person for PF, entao nao temos os dados da empresa, mas sim do cliente */
      if (isset($purchase->customer['person']) && $purchase->customer['person'] === Person::PF->value) {
        $this->addressNumber = $purchase->customer['number'];
        $this->postalCode = $purchase->customer['postal_code'];
      }

      # Dados da emprea
      if (isset($purchase->customer['person']) && $purchase->customer['person'] === Person::PJ->value) {
        $this->company       = $purchase->company['name'];
        $this->document      = $purchase->company['document'];
        $this->addressNumber = $purchase->company['number'];
        $this->postalCode    = $purchase->company['postal_code'];
      }
    } catch (\Throwable $th) {
      throw new CustomerException('Erro ao criar a estrutura de dados para enviar o Cliente para o ASAAS',  $th->getMessage());
    }
  }
}
