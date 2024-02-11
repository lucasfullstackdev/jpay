<?php

namespace App\Jobs;

use App\Dtos\Customer\CustomerOshi;
use App\Http\Requests\Purchase;
use App\Models\Customer;
use App\Services\Banking\Asaas\AsaasCustomer;
use App\Services\Banking\BankingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateExternalCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private BankingService $bankingService;
    // public Purchase $purchase;

    /**
     * Create a new job instance.
     */
    public function __construct(public $purchase)
    {
        $this->bankingService = new BankingService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CreateBillingJob::dispatch(
            Customer::create($this->sendCustomer($this->purchase))
        );
    }

    private function sendCustomer($purchase): array
    {
        return (array) $this->bankingService->createCustomer(
            new AsaasCustomer((object) $purchase)
        );
    }
}
