<?php

namespace App\Jobs;

use App\Exceptions\CreateException;
use App\Models\Document;
use App\Models\DocumentSigner;
use App\Models\Signer;
use App\Services\Signature\ClickSign\ClickSignSigner;
use App\Services\Signature\SignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateSignerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SignatureService $signatureService;

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
        /** 
         * se o customer já tiver signatário mapeado, não pode permitir criar outro
         * no momento não iremos permitir que um customer assine mais de um documento
         */
        if ($this->hasSigner()) {
            return;
        }

        $response = $this->sendSigner();
        try {
            /** Criando o signatário */
            DB::beginTransaction();
            $signer = Signer::create($response);
            DB::commit();
        } catch (\Throwable $th) {
            throw new CreateException('Erro ao salvar signatário no Banco de Dados', $th->getMessage());
        }

        // Após criar o signatário, dispara o job para adicionar o signatário ao documento
        AddSignerToDocumentJob::dispatch($this->document, $signer);
    }

    private function sendSigner(): array
    {
        return (array) $this->signatureService->sendSigner(
            new ClickSignSigner($this->document)
        );
    }

    private function hasSigner(): bool
    {
        return (bool) Signer::where('customer', $this->document->customer)->first() ?? null;
    }
}
