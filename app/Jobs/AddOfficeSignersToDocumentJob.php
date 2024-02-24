<?php

namespace App\Jobs;

use App\Dtos\Document\DocumentSigner;
use App\Models\Document;
use App\Models\DocumentSigner as ModelsDocumentSigner;
use App\Models\OfficeSigner;
use App\Services\Signature\SignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AddOfficeSignersToDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SignatureService $signatureService;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document, public OfficeSigner $officeSigner)
    {
        $this->signatureService = new SignatureService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $documentSignerOshi = $this->sendSigner();

        DB::beginTransaction();
        ModelsDocumentSigner::create($documentSignerOshi);
        DB::commit();
    }

    private function sendSigner(): ?array
    {
        return (array) $this->signatureService->addSignerToDocument(
            new DocumentSigner($this->document, $this->officeSigner)
        );
    }
}
