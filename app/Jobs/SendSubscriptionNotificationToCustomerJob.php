<?php

namespace App\Jobs;

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

    private function getSigners(): ?DocumentSigner
    {
        return DocumentSigner::where('document', $this->document->document_id)
            ->whereNotIn('signer', function ($query) {
                $query->select('signer_id')->from('office_signers');
            })->first() ?? null;
    }

    private function sendNotification(): array
    {
        return (array) $this->signatureService->sendNotification(
            new ClickSignNotification($this->signer)
        );
    }
}
