<?php

namespace App\Services;

use App\Http\Requests\Purchase;
use App\Services\Banking\CustomerService;

class TaxDomicileService extends Service
{
  public function __construct(private CustomerService $customerService)
  {
  }

  public function purchase(Purchase $request)
  {
    $customer = $this->customerService->store($request);
    
    dd($customer);
    dd($request->all());
  }
}
