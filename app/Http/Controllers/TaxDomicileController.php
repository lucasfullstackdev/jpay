<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase;
use App\Services\CustomerService;
use App\Services\TaxDomicileService;

class TaxDomicileController extends Controller
{
    public function __construct(private TaxDomicileService $taxDomicileService)
    {
    }

    public function purchase(Purchase $request)
    {
        $this->taxDomicileService->purchase($request);

        // dd($request->all());
    }
}
