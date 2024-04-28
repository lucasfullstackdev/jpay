<?php

namespace App\Jobs;

use App\Models\CMS\CMSUser;
use App\Models\Customer;
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
    public function __construct(private Customer $customer)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            CMSUser::where('user_login', $this->customer->document)->limit(1)
                ->update(['user_url' => 'https://activate.oshi']);
        } catch (\Throwable $th) {
        }
    }
}
