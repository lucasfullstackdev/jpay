<?php

namespace App\Services;

use App\Dtos\Customer\CustomerOshi;
use App\Enums\Person;
use App\Exceptions\CreateException;
use App\Models\{Company, Customer};
use App\Services\Banking\Asaas\AsaasCustomer;
use App\Services\Banking\BankingService;
use Illuminate\Support\Facades\DB;

class CustomerService
{

  public function __construct(private BankingService $bankingService)
  {
  }

  public function createExternalCustomer($purchase): Customer
  {
    $customerToUpdate = $this->sendCustomer($purchase);

    /**
     * Só cadastrar o cliente e a empresa se conseguirmos enviar o cliente para o ASAAS
     */
    try {
      DB::beginTransaction();

      $customerOshi = new CustomerOshi((object) $purchase);

      // Cadastro do cliente
      $customerOshi->sku = $customerToUpdate->sku;
      $customer = Customer::create((array) $customerOshi);

      // Se for PJ, cadastrar a empresa
      if (isset($purchase->customer['person']) && $purchase->customer['person'] === Person::PJ->value) {
        $customerOshi->company->owner_id = $customer->id;
        Company::create((array) $customerOshi->company);
      }

      DB::commit();

      return $customer;
    } catch (\Throwable $th) {
      DB::rollBack();
      throw new CreateException('Erro ao criar o cliente', $th->getMessage());
    }
  }

  private function sendCustomer($purchase): object
  {
    return $this->bankingService->createCustomer(
      new AsaasCustomer((object) $purchase)
    );
  }
}
