<?php

namespace App\Jobs;

use App\Enums\AsaasEvent;
use App\Models\BillingMonitoring;
use App\Services\DocumentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DocumentService $documentService;

    private array $eventsToDispachDocument = [
        AsaasEvent::PAYMENT_RECEIVED->value,
        AsaasEvent::PAYMENT_CONFIRMED->value,
    ];

    /**
     * Create a new job instance.
     */
    public function __construct(public object $request)
    {
        $this->documentService = app(DocumentService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /**
         * Verifica se já existe confirmação de pagamento para essa assinatura
         * Se já existir, não faz nada, assim evitamos a criação de documento para 
         * cada pagamento recebido da mesma assinatura
         */
        Log::info(json_encode($this->request->payment));
        if ($this->thereIsAlreadyPaymentConfirmationForThisSubscription($this->request->payment['subscription'])) {
            return;
        }

        /**
         * O status precisa ser:
         * 
         * - RECEIVED (Pagamento Recebido) -> para Boleto e pix
         * - CONFIRMED (Pagamento Confirmado) -> para Cartão de Crédito
         */
        if (!in_array($this->request->event, $this->eventsToDispachDocument)) {
            return;
        }

        // Após criar o documento, dispara o job para criar o signer
        $document = $this->documentService->createDocument((object) $this->request->payment);
        if (empty($document)) {
            return;
        }

        CreateSignerJob::dispatch($document);
    }

    // private function There is already payment confirmation for this subscription
    private function thereIsAlreadyPaymentConfirmationForThisSubscription($subscriptionId): bool
    {
        return BillingMonitoring::where('subscription_id', $subscriptionId)
            ->whereIn('event', $this->eventsToDispachDocument)
            ->exists();
    }
}
