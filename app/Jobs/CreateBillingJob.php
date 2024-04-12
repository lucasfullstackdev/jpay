<?php

namespace App\Jobs;

use App\Services\Banking\Asaas\AsaasBilling;
use App\Services\BillingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateBillingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private BillingService $billingService;

    /**
     * Create a new job instance.
     */
    public function __construct(public AsaasBilling $billing)
    {
        $this->billingService = app(BillingService::class, ['billing' => $billing]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Enviar cobranca para ser salva no ASAAS
        $this->billingService->createBilling();
    }
}
