<?php

namespace App\Console\Commands;

use App\Events\WeeklyEvent;
use App\Models\Subscription;
use Illuminate\Console\Command;

class WeeklySalesReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weekly-sales-report-command';

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
        $subscriptions = $this->getSubscriptions();
        if ($subscriptions->isEmpty()) {
            return;
        }

        foreach ($subscriptions as $subscription) {
            // Não é possivel enviar o relatório sem o voucher ou afiliado existentes e validos
            if (empty($subscription->voucherModel) || empty($subscription->affiliateModel)) {
                continue;
            }

            // Não é possivel enviar o relatório sem o email do afiliado
            if (empty($subscription->affiliateModel->email)) {
                continue;
            }

            // Agrupando as vendas por afiliado
            $affiliateSales[$subscription->affiliateModel->email]['affiliate'] = [
                'email' => $subscription->affiliateModel->email,
                'code' => $subscription->affiliateModel->slug,
            ];

            $affiliateSales[$subscription->affiliateModel->email]['subscriptions'][] = [
                'date' => $subscription->created_at->format('d/m/Y'),
                'value' => $subscription->value,
                'voucher' => [
                    'code' => $subscription->voucher_code,
                    'affiliate_percentage' => $subscription->voucherModel->affiliate_percentage,
                    'commission' => $subscription->value * ($subscription->voucherModel->affiliate_percentage / 100)
                ]
            ];
        }

        // Calculando o total de vendas, comissões e quantidade de vendas por afiliado
        $affiliateSales = collect($affiliateSales)->map(function ($item, $key) {
            $item['total_value'] = collect($item['subscriptions'])->sum('value');
            $item['total_commission'] = collect($item['subscriptions'])->sum('affiliate.commission');
            $item['quantity'] = count($item['subscriptions']);
            return $item;
        });

        event(
            new WeeklyEvent($affiliateSales)
        );
    }

    private function getSubscriptions()
    {
        return Subscription::with('voucherModel', 'affiliateModel')->where([
            ['subscriptions.created_at', '>=', now()->subWeek()],
            ['subscriptions.created_at', '<=', now()],
            ['subscriptions.voucher_code', '!=', ''],
            ['subscriptions.affiliate_code', '!=', '']
        ])->join('vouchers', 'subscriptions.voucher_code', '=', 'vouchers.code')
            ->join('affiliates', 'subscriptions.affiliate_code', '=', 'affiliates.slug')
            ->join('affiliate_vouchers', function ($join) {
                $join->on('vouchers.code', '=', 'affiliate_vouchers.voucher')
                    ->on('affiliates.id', '=', 'affiliate_vouchers.affiliate_id');
            })
            ->select(
                'subscriptions.*',
                'vouchers.percentage',
                'vouchers.affiliate_percentage',
                'affiliates.email'
            )
            ->get();
    }
}
