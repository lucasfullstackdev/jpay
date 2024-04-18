<?php

namespace App\Services;

use App\Http\Requests\Purchase;
use App\Jobs\{CreateBillingJob, CreateExternalCustomerJob};
use App\Models\Customer;
use App\Services\Banking\Asaas\AsaasBilling;

class TaxDomicileService extends Service
{
  public function purchase(Purchase $purchase)
  {
    $customer = $this->getCustomer($purchase->customer);

    if (!empty($customer)) {
      return CreateBillingJob::dispatch(
        new AsaasBilling($customer)
      );
    }

    /* Se Cliente nao existir, criar */
    CreateExternalCustomerJob::dispatch(
      $purchase->only(['customer', 'company'])
    );
  }

  public function getCustomer(array $customer): ?Customer
  {
    return Customer::where('document', $customer['document'])->first() ?? null;
  }
}
