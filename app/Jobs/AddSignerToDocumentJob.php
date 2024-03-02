<?php

namespace App\Jobs;

use App\Dtos\Document\DocumentSigner;
use App\Models\Document;
use App\Models\DocumentSigner as ModelsDocumentSigner;
use App\Models\OfficeSigner;
use App\Models\Signer;
use App\Services\Signature\SignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AddSignerToDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SignatureService $signatureService;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document, public Signer $signer)
    {
        $this->signatureService = new SignatureService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $documentSignerOshi = $this->sendSigner();

            DB::beginTransaction();
            ModelsDocumentSigner::create($documentSignerOshi);
            DB::commit();

            /** 
             * como conseguimos atribuir o cliente ao documento, agora iremos adicionar os demais signatários
             * Um job para cada signatário para que possamos paralelizar a adição dos signatários
             * 
             * só pegaremos os signatários que possuem secret, pois são os que conseguem assinar automaticamente
             */
            $officeSigners = OfficeSigner::whereNotNull('secret')->get();
            foreach ($officeSigners as $officeSigner) {
                AddOfficeSignersToDocumentJob::dispatch($this->document, $officeSigner);
            }

            /* Agora que todos os signatários foram adicionados, podemos enviar o documento para assinatura */
            SendSubscriptionNotificationToCustomerJob::dispatch($this->document);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private function sendSigner(): array
    {
        return (array) $this->signatureService->addSignerToDocument(
            new DocumentSigner($this->document, $this->signer)
        );
    }
}
