<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase;
use App\Http\Requests\Webhook\Asaas;
use App\Jobs\AsaasWebhookJob;
use App\Jobs\CreateDocumentJob;
use App\Services\TaxDomicileService;
use Symfony\Component\HttpFoundation\Response;

class TaxDomicileController extends Controller
{
    public function __construct(private TaxDomicileService $taxDomicileService)
    {
    }

    public function purchase(Purchase $request)
    {
        $this->taxDomicileService->purchase($request);
    }

    public function webhook(Asaas $request)
    {
        CreateDocumentJob::dispatch((object) $request->payment);

        // AsaasWebhookJob::dispatch($request->only(['event', 'payment']));

        // return response()->json([], Response::HTTP_OK);
    }
}
