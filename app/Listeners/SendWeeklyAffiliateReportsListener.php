<?php

namespace App\Listeners;

use App\Jobs\SendAffiliateSalesReportByEmailJob;
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
        // Disparando o envio do email para cada afiliado, assim diminui a carga de processamento
        $event->affiliateSales->each(fn ($affiliate) => SendAffiliateSalesReportByEmailJob::dispatch($affiliate));
    }
}
