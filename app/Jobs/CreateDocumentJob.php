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

class CreateDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DocumentService $documentService;

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
         * Verifica se o evento é PAYMENT_RECEIVED
         * Se não for, não faz nada
         */
        if ($this->request->event != AsaasEvent::PAYMENT_RECEIVED->value) {
            return;
        }

        /**
         * Verifica se já existe confirmação de pagamento para essa assinatura
         * Se já existir, não faz nada, assim evitamos a criação de documento para 
         * cada pagamento recebido da mesma assinatura
         */
        if ($this->thereIsAlreadyPaymentConfirmationForThisSubscription($this->request->payment['subscription'])) {
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
            ->where('event', AsaasEvent::PAYMENT_RECEIVED->value)
            ->exists();
    }
}
