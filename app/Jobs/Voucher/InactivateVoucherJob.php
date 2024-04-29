<?php

namespace App\Jobs\Voucher;

use App\Enums\Payment\VoucherType;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InactivateVoucherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private object $voucher)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $voucher = Voucher::with('type')->where('code', $this->voucher->code)->first();
            if (empty($voucher)) {
                return;
            }

            if ($voucher->type->name === VoucherType::ONE_TIME->value) {
                $voucher->delete();
            }
        } catch (\Throwable $th) {
        }
    }
}
