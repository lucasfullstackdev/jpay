<?php

namespace App\Services;

use App\Http\Requests\Purchase;
use App\Jobs\CreateBillingJob;
use App\Jobs\CreateExternalCustomerJob;
use App\Models\Customer;
use App\Services\Banking\Asaas\AsaasBilling;

class TaxDomicileService extends Service
{
  public function purchase(Purchase $purchase)
  {
    $customer = $this->getCustomer($purchase->document);
    if (!empty($customer)) {
      return CreateBillingJob::dispatch(
        new AsaasBilling($customer)
      );
    }

    /* Se Cliente nao existir, criar */
    return CreateExternalCustomerJob::dispatch(
      $purchase->only(['name', 'email', 'phone', 'document', 'company'])
    );
  }

  public function getCustomer(string $document): ?Customer
  {
    return Customer::where('document', $document)->first() ?? null;
  }
}
