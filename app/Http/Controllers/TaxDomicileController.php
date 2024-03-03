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
use App\Models\DocumentMonitoring;
use App\Services\TaxDomicileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TaxDomicileController extends Controller
{
    public function __construct(private TaxDomicileService $taxDomicileService)
    {
    }

    public function purchase(Purchase $request)
    {
        /** Aplicando o hash para garantir que a requisição já não foi recebida antes */
        $identifier = hash('sha256', json_encode($request->all()));
        if ($this->purcharRequestHasAlreadyBeenReceived($identifier)) {
            return response()->json([
                'success' => true,
                'message' => 'Você já enviou uma requisição com esses dados. Aguarde o processamento da sua requisição.',
            ], Response::HTTP_CONFLICT);
        }

        /**
         * Aqui eu estou usando o Cache para garantir que a requisição não seja processada 
         * mais de uma vez em um intervalo de 24 horas
         */
        $this->taxDomicileService->purchase($request);
        Cache::put($identifier, true, now()->addHours(24));

        return response()->json([
            'success' => true,
            'message' => 'Requisição recebida com sucesso',
        ], Response::HTTP_CREATED);
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
        if ($this->asaasRequestHasAlreadyBeenReceived($identifier)) {
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
        $identifier = hash('sha256', json_encode($request->all()));
        if ($this->clickSignRequestHasAlreadyBeenReceived($identifier)) {
            return response()->json([], Response::HTTP_OK);
        }

        ClickSignWebhookJob::dispatch($request->all(), $identifier);

        return response()->json([], Response::HTTP_OK);
    }

    private function asaasRequestHasAlreadyBeenReceived($identifier): bool
    {
        return BillingMonitoring::where('identifier', $identifier)->exists();
    }

    private function clickSignRequestHasAlreadyBeenReceived($identifier): bool
    {
        return DocumentMonitoring::where('identifier', $identifier)->exists();
    }

    private function purcharRequestHasAlreadyBeenReceived($identifier): bool
    {
        return Cache::has($identifier);
    }
}
