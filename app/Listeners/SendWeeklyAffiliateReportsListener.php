<?php

namespace App\Listeners;

use App\Jobs\SendAffiliateSalesReportByEmailJob;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWeeklyAffiliateReportsListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->affiliateSales->each(fn ($affiliate) => SendAffiliateSalesReportByEmailJob::dispatch($affiliate));
    }
}
