<?php

namespace App\Services;

use App\Exceptions\CreateException;
use App\Models\BillingSending;
use App\Models\Subscription;
use App\Services\Banking\Asaas\AsaasSubscription;
use App\Services\Banking\BankingService;

class SubscriptionService
{
  // private AsaasBilling $subscription;

  public function __construct(public BankingService $bankingService, public AsaasSubscription $subscription)
  {
  }

  public function createSubscription(): void
  {
    // So devemos permitir caso o cliente nao tenha comprado no ultimo ano
    // if ($this->hasBillingActive()) {
    //   return;
    // }

    // Enviar cobranca para ser salva no ASAAS
    $subscription = $this->sendSubscription();

    try {
      Subscription::create($subscription);
    } catch (\Throwable $th) {
      throw new CreateException('Erro ao salvar assinatura no Banco de Dados', $th->getMessage());
    }
  }

  /**
   * Regra que deve ser implementada para evitar multiplas cobrancas:
   * 
   * se cliente nunca comprou -> enviar cobranca
   * se cliente possui uma compra feita em menos de 12 meses -> bloquear
   * se cliente nao possui uma compra feita em menos de 12 meses -> enviar cobranca
   */
  // private function hasBillingActive(): bool
  // {
  //   $subscription = $this->getBilling();

  //   // Se nao tiver cobranca, permitir que possa criar uma nova cobranca
  //   if (empty($subscription)) {
  //     return false;
  //   }

  //   // Se o domicílio fiscal tiver menos de 1 ano, não premitir criar nova cobranca
  //   if ($this->billingMadeInLessThanAYear($subscription)) {
  //     return true;
  //   }

  //   return false;
  // }

  // public function billingMadeInLessThanAYear(BillingSending $subscription): bool
  // {
  //   return $subscription->wasMadeInLessThanAYear();
  // }

  // private function getBilling(): ?BillingSending
  // {
  //   return BillingSending::where('customer', $this->billing->customer)->orderBy('created_at', 'desc')->first() ?? null;
  // }

  private function sendSubscription()
  {
    return (array) $this->bankingService->createSubscription(
      $this->subscription
    );
  }
}
