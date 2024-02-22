<?php

namespace App\Jobs;

use App\Models\BillingSending;
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
        // if ($this->hasDocument()) {
        //     return;
        // }

        try {
            $document = $this->sendDocument();

            DB::beginTransaction();
            $document = Document::create($document);
            DB::commit();

            CreateSignerJob::dispatch($document);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
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
