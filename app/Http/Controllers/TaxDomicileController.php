<?php

namespace App\Http\Controllers;

use App\Enums\AsaasEvent;
use App\Http\Requests\Purchase;
use App\Http\Requests\Webhook\Asaas;
use App\Http\Requests\Webhook\ClickSign;
use App\Jobs\AsaasWebhookJob;
use App\Jobs\ClickSignWebhookJob;
use App\Jobs\CreateDocumentJob;
use App\Models\BillingMonitoring;
use App\Services\TaxDomicileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
     * Aqui as regras são:
     * - Verificar se a requisição já foi recebida
     * - Independente do evento, dispara o job para salvar o webhook
     * - Se o evento for PAYMENT_RECEIVED, dispara o job para criar o documento
     * - Retornar 200 rapidamente para o Asaas
     */
    public function purchaseWebhook(Asaas $request)
    {
        /** Aplicando o hash_hmac para garantir que a requisição já não foi recebida antes */
        $identifier = hash_hmac('sha256', $request->payment['id'], $request->event);
        if ($this->requestHasAlreadyBeenReceived($identifier)) {
            return response()->json([], Response::HTTP_OK);
        }

        AsaasWebhookJob::dispatch($request->only(['event', 'payment']), $identifier);
        if ($request->event == AsaasEvent::PAYMENT_RECEIVED->value) {
            CreateDocumentJob::dispatch((object) $request->payment);
        }

        return response()->json([], Response::HTTP_OK);
    }

    public function documentWebhook(ClickSign $request)
    {
        ClickSignWebhookJob::dispatch($request->all());

        return response()->json([], Response::HTTP_OK);
    }

    // the request has already been received before

    private function requestHasAlreadyBeenReceived($identifier): bool
    {
        return BillingMonitoring::where('identifier', $identifier)->exists();
    }
}
