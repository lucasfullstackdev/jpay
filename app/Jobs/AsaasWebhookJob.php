<?php

namespace App\Jobs;

use App\Models\BillingMonitoring;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AsaasWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $request)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        BillingMonitoring::create([
            'event' => $this->request['event'],
            'payment_id' => $this->request['payment']['id'],
            'payment' => json_encode($this->request['payment'])
        ]);
    }
}
