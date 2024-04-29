<?php

namespace App\Services;

use App\Exceptions\CreateException;
use App\Jobs\Voucher\InactivateVoucherJob;
use App\Models\Subscription;
use App\Services\Banking\Asaas\AsaasSubscription;
use App\Services\Banking\BankingService;

class SubscriptionService
{
  public function __construct(public BankingService $bankingService, public AsaasSubscription $subscription)
  {
  }

  public function createSubscription(): void
  {
    // So devemos permitir caso o cliente nao tenha comprado no ultimo ano
    if ($this->hasActiveSubscription()) {
      return;
    }

    // Enviar assinatura para ser salva no ASAAS
    $subscription = $this->sendSubscription();

    try {
      Subscription::create($subscription);

      // Inativar voucher se for do tipo ONE_TIME
      InactivateVoucherJob::dispatch(json_decode($subscription['voucher']));
    } catch (\Throwable $th) {
      throw new CreateException('Erro ao salvar assinatura no Banco de Dados', $th->getMessage());
    }
  }

  /**
   * Regra que deve ser implementada para evitar multiplas assinaturas para o mesmo cliente:
   * 
   * se cliente nunca comprou -> enviar assinatura
   * se cliente comprou -> nao enviar assinatura
   */
  private function hasActiveSubscription(): bool
  {
    return !empty($this->getSubscription());
  }

  private function getSubscription(): ?Subscription
  {
    return Subscription::where('customer', $this->subscription->customer)->orderBy('created_at', 'desc')->first() ?? null;
  }

  private function sendSubscription()
  {
    return (array) $this->bankingService->createSubscription(
      $this->subscription
    );
  }
}
