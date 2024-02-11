<?php

namespace App\Services\Banking;

use App\Dtos\Customer\CustomerOshi;
use App\Http\Requests\Purchase;
use App\Models\Customer;
use App\Services\Banking\Asaas\AsaasCustomer;
use App\Services\Banking\BankingService;
use App\Services\Service;

class CustomerService extends Service
{
  public function __construct(private BankingService $bankingService)
  {
  }

  /**
   * Se cliente já existir, retornar a model
   * Se cliente não existir, criar e retornar a model
   */
  public function store(Purchase $purchase)
  {
    $customer = $this->getCustomer($purchase->document);
    if (!empty($customer)) {
      return $customer;
    }

    return Customer::create((array) $this->sendCustomer($purchase));
  }

  public function getCustomer(string $document): ?Customer
  {
    return Customer::where('document', $document)->first() ?? null;
  }

  private function sendCustomer(Purchase $purchase): CustomerOshi
  {
    return $this->bankingService->createCustomer(
      new AsaasCustomer($purchase)
    );
  }
}
