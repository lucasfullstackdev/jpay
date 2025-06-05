<?php

namespace App\Jobs;

use App\Enums\Email;
use App\Mail\AffiliateSalesReportMail;
use App\Models\ViewAffiliateSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAffiliateSalesReportByEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ViewAffiliateSubscription $affiliateSales)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->affiliateSales->affiliate->email)
            ->bcc(Email::FINANCEIRO->value)
            ->send(
                new AffiliateSalesReportMail($this->affiliateSales)
            );
    }
}
