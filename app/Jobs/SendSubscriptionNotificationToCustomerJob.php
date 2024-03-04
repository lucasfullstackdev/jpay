<?php

namespace App\Jobs;

use App\Enums\SignerAs;
use App\Models\Document;
use App\Models\DocumentSigner;
use App\Services\Signature\ClickSign\ClickSignNotification;
use App\Services\Signature\SignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSubscriptionNotificationToCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SignatureService $signatureService;
    private DocumentSigner $signer;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document)
    {
        $this->signatureService = new SignatureService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->signer = $this->getSigners();

        // Se não houver signatários, não há o que fazer
        if (empty($this->signer)) {
            return;
        }

        $this->sendNotification();
    }

    private function getSigners()
    {
        return DocumentSigner::where([
            'document' => $this->document->document_id,
            'sign_as' => SignerAs::SIGN->value,
        ])->join('signers', 'document_signers.signer', '=', 'signers.signer_id')->first();
    }

    private function sendNotification(): array
    {
        return (array) $this->signatureService->sendNotification(
            new ClickSignNotification($this->signer)
        );
    }
}
