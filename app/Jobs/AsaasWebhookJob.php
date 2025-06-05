<?php

namespace App\Jobs;

use App\Exceptions\CreateException;
use App\Models\BillingMonitoring;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AsaasWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public object $request, public string $identifier)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            BillingMonitoring::create([
                'identifier' => $this->identifier,
                'event' => $this->request->event,
                'payment_id' => $this->request->payment['id'],
                'customer_id' => $this->request->payment['customer'],
                'subscription_id' => $this->request->payment['subscription'] ?? '',
                'value' => $this->request->payment['value'],
                'payment' => json_encode($this->request->payment)
            ]);
        } catch (\Throwable $th) {
            throw new CreateException('Erro ao salvar Webhook do ASAAS no Banco de Dados', $th->getMessage());
        }
    }
}
