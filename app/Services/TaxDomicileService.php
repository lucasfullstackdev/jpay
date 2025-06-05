<?php

namespace App\Services;

use App\Enums\Person;
use App\Http\Requests\Purchase;
use App\Jobs\{CreateExternalCustomerJob, CreateSubscriptionJob};
use App\Models\Customer;
use App\Services\Banking\Asaas\AsaasSubscription;

class TaxDomicileService extends Service
{
  public function purchase(Purchase $purchase)
  {
    $customer = $this->getCustomer($purchase->customer);
    /** Se o cliente já existir, criar a cobrança */
    if (!empty($customer)) {
      return CreateSubscriptionJob::dispatch(
        new AsaasSubscription($customer, $purchase->payment)
      );
    }

    /** Se a Landing Page informar que é empresa, então utilizar os dados da empresa */
    $extractDataFromRequest = ['customer', 'payment'];
    if ($purchase->customer['person'] === Person::PJ->value) {
      $extractDataFromRequest[] = 'company';
    }

    /* Se Cliente nao existir, criar */
    CreateExternalCustomerJob::dispatch(
      $purchase->only($extractDataFromRequest)
    );
  }

  public function getCustomer(array $customer): ?Customer
  {
    return Customer::where('document', $customer['document'])->first() ?? null;
  }
}
