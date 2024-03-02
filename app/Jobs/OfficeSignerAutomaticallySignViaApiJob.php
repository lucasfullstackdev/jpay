<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\DocumentSigner;
use App\Models\OfficeSigner;
use App\Services\Signature\ClickSign\ClickSignApiSign;
use App\Services\Signature\SignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OfficeSignerAutomaticallySignViaApiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SignatureService $signatureService;
    private DocumentSigner $documentSigner;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document, public OfficeSigner $officeSigner)
    {
        $this->signatureService = new SignatureService();

        $this->documentSigner = DocumentSigner::where('document', $document->document_id)
            ->where('signer', $officeSigner->signer_id)
            ->first();

        /* Se não encontrar o signatário no documento, não pode assinar automaticamente */
        if (empty($this->documentSigner)) {
            return;
        }

        /* Se signatário não tiver secret, não pode assinar automaticamente */
        if (empty($this->officeSigner->secret)) {
            return;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->signDocument();
    }

    private function signDocument(): void
    {
        $this->signatureService->signDocument(
            new ClickSignApiSign($this->documentSigner->request_signature_key, $this->calcHmac())
        );
    }

    private function calcHmac(): string
    {
        return hash_hmac('sha256', $this->documentSigner->request_signature_key, $this->officeSigner->secret);
    }
}
