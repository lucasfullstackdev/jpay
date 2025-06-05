<?php

namespace App\Jobs;

use App\Services\Banking\Asaas\AsaasSubscription;
use App\Services\SubscriptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SubscriptionService $subscriptionService;

    /**
     * Create a new job instance.
     */
    public function __construct(public AsaasSubscription $subscription)
    {
        $this->subscriptionService = app(SubscriptionService::class, ['subscription' => $subscription]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Enviar cobranca para ser salva no ASAAS
        $this->subscriptionService->createSubscription();
    }
}
