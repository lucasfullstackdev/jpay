<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase;
use App\Http\Requests\Webhook\Asaas;
use App\Http\Requests\Webhook\ClickSign;
use App\Jobs\AsaasWebhookJob;
use App\Jobs\ClickSignWebhookJob;
use App\Jobs\CreateDocumentJob;
use App\Services\TaxDomicileService;
use Illuminate\Http\Request;
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

    /**
     * Aqui a regra é a seguinte:
     * - Receber o webhook do Asaas e salvar todos os dados no banco de dados
     * - Se for reconhecido o pagamento, criar um documento fiscal e seguir fluxo normal
     */
    public function purchaseWebhook(Asaas $request)
    {
        CreateDocumentJob::dispatch((object) $request->payment);

        // AsaasWebhookJob::dispatch($request->only(['event', 'payment']));
        // CreateDocumentJob::dispatch($request->all());

        // return response()->json([], Response::HTTP_OK);
    }

    public function documentWebhook(ClickSign $request)
    {
        ClickSignWebhookJob::dispatch($request->all());

        return response()->json([], Response::HTTP_OK);
    }
}
