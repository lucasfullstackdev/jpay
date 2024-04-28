<?php

namespace App\Jobs;

use App\Models\CMS\CMSUser;
use App\Models\Customer;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ActivateUserInCorrespondenceManagementSystemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $document)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Verificar se o documento existe
        $document = $this->getDocument();
        if (empty($document)) {
            return;
        }

        // Verificar se o cliente existe
        $customer = $this->getCustomer($document->customer);
        if (empty($customer)) {
            return;
        }

        try {
            CMSUser::where('user_login', $customer->document)->limit(1)
                ->update(['user_url' => 'https://activate.oshi']);
        } catch (\Throwable $th) {
        }
    }

    private function getDocument(): Document
    {
        return Document::where('document_id', $this->document)->first();
    }

    private function getCustomer(string $documentCustomer): Customer
    {
        return Customer::where('sku', $documentCustomer)->first();
    }
}
