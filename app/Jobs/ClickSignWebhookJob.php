<?php

namespace App\Jobs;

use App\Exceptions\CreateException;
use App\Models\DocumentMonitoring;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClickSignWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $request, public string $identifier)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DocumentMonitoring::create([
                'identifier' => $this->identifier,
                'document' => $this->request['document']['key'],
                'event_name' => $this->request['event']['name'],
                'event' => json_encode($this->request['event']),
            ]);
        } catch (\Throwable $th) {
            throw new CreateException('Erro ao salvar Webhook da ClickSign no Banco de Dados', $th->getMessage());
        }
    }
}
