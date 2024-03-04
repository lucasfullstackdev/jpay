<?php

namespace App\Jobs;

use App\Exceptions\CreateException;
use App\Models\Customer;
use App\Models\Document;
use App\Services\Signature\ClickSign\ClickSignDocument;
use App\Services\Signature\SignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SignatureService $signatureService;
    private Customer $customer;

    /**
     * Create a new job instance.
     */
    public function __construct(public object $payment)
    {
        $this->signatureService = new SignatureService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->customer = $this->getCustomer();
        /** Se nao encontrar o customer, barrar */
        if (empty($this->customer)) {
            return;
        }

        /** Se encontrar documento, barrar */
        if ($this->hasDocument()) {
            return;
        }

        // Envia o documento para a ClickSign
        $document = $this->sendDocument();

        // Cria o documento no banco de dados
        try {
            DB::beginTransaction();
            $document = Document::create($document);
            DB::commit();
        } catch (\Throwable $th) {
            throw new CreateException('Erro ao salvar Documento no Banco de Dados', $th->getMessage());
        }

        // Após criar o documento, dispara o job para criar o signer
        CreateSignerJob::dispatch($document);
    }

    private function getCustomer()
    {
        return Customer::with('company')->where('sku', $this->payment->customer)->first();
    }

    private function hasDocument(): bool
    {
        return (bool) Document::where('customer', $this->customer->sku)->first() ?? null;
    }

    private function sendDocument()
    {
        return (array) $this->signatureService->sendDocument(
            new ClickSignDocument($this->customer)
        );
    }
}
