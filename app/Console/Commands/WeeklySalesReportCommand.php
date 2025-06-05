<?php

namespace App\Console\Commands;

use App\Events\WeeklyEvent;
use App\Models\Subscription;
use App\Models\ViewAffiliateSubscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class MonthlySalesReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monthly-sales-report-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para que irá disparar um evento de geração de relatório de vendas semanal.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $affiliateSales = $this->getAffiliateSales();

        if ($affiliateSales->isEmpty()) {
            return;
        }

        // Filtrando os afiliados com e-mails validos
        $affiliateSales = $affiliateSales->filter(fn ($subscription) => $this->emailIsValid($subscription->affiliate->email));

        foreach ($affiliateSales as $affiliateSale) {
            // dd($affiliateSale->toArray());
        }

        // Disparando o evento de geração de relatório semanal
        event(
            new WeeklyEvent($affiliateSales)
        );
    }

    private function getAffiliateSales(): \Illuminate\Database\Eloquent\Collection
    {
        return ViewAffiliateSubscription::all();
    }

    private function emailIsValid(string $email): bool
    {
        $validator = Validator::make(['email' => $email], [
            'email' => 'email:rfc,dns'
        ]);

        return !$validator->fails();
    }
}
