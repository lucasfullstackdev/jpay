<?php

namespace App\Services;

use App\Exceptions\CreateException;
use App\Models\BillingSending;
use App\Services\Banking\Asaas\AsaasBilling;
use App\Services\Banking\BankingService;

class BillingService
{
  // private AsaasBilling $billing;

  public function __construct(public BankingService $bankingService, public AsaasBilling $billing)
  {
  }

  public function createBilling(): void
  {
    // So devemos permitir caso o cliente nao tenha comprado no ultimo ano
    if ($this->hasBillingActive()) {
      return;
    }

    // Enviar cobranca para ser salva no ASAAS
    $billing = $this->sendBilling();

    try {
      BillingSending::create($billing);
    } catch (\Throwable $th) {
      throw new CreateException('Erro ao salvar cobrança no Banco de Dados', $th->getMessage());
    }
  }

  /**
   * Regra que deve ser implementada para evitar multiplas cobrancas:
   * 
   * se cliente nunca comprou -> enviar cobranca
   * se cliente possui uma compra feita em menos de 12 meses -> bloquear
   * se cliente nao possui uma compra feita em menos de 12 meses -> enviar cobranca
   */
  private function hasBillingActive(): bool
  {
    $billing = $this->getBilling();

    // Se nao tiver cobranca, permitir que possa criar uma nova cobranca
    if (empty($billing)) {
      return false;
    }

    // Se o domicílio fiscal tiver menos de 1 ano, não premitir criar nova cobranca
    if ($this->billingMadeInLessThanAYear($billing)) {
      return true;
    }

    return false;
  }

  public function billingMadeInLessThanAYear(BillingSending $billing): bool
  {
    return $billing->wasMadeInLessThanAYear();
  }

  private function getBilling(): ?BillingSending
  {
    return BillingSending::where('customer', $this->billing->customer)->orderBy('created_at', 'desc')->first() ?? null;
  }

  private function sendBilling()
  {
    return (array) $this->bankingService->createBilling(
      $this->billing
    );
  }
}
