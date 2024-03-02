<?php

namespace App\Jobs;

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
    public function __construct(public array $request)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DocumentMonitoring::create([
            'document' => $this->request['document']['key'],
            'event_name' => $this->request['event']['name'],
            'event' => json_encode($this->request['event']),
        ]);
    }
}
