<?php

namespace App\Jobs;

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
    public function __construct(public object $payment)
    {
        $this->documentService = app(DocumentService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Após criar o documento, dispara o job para criar o signer
        $document = $this->documentService->createDocument($this->payment);

        if (empty($document)) {
            return;
        }

        CreateSignerJob::dispatch($document);
    }
}
