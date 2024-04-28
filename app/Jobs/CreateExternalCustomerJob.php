<?php

namespace App\Jobs;

use App\Services\Banking\Asaas\AsaasBilling;
use App\Services\Banking\Asaas\AsaasSubscription;
use App\Services\CustomerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class CreateExternalCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CustomerService $customerService;

    /**
     * Create a new job instance.
     */
    public function __construct(public $purchase)
    {
        $this->customerService = app(CustomerService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** Enviando o cliente para o ASAAS */
        $customer = $this->customerService->createExternalCustomer($this->purchase);

        CreateSubscriptionJob::dispatch(
            new AsaasSubscription($customer, $this->purchase['payment'])
        );
    }
}
