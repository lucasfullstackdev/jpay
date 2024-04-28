<?php

namespace App\Services\Banking\Asaas;

use App\Enums\Payment\PaymentValue;
use App\Exceptions\SubscriptionException;
use App\Services\Banking\CustomerInterface;
use Carbon\Carbon;

class AsaasSubscription implements CustomerInterface
{
  public string $billingType;
  public string $cycle;
  public float $value;
  public string $nextDueDate;
  public string $description;

  public string $customer;

  /**
   * 
   */
  public function __construct(object $customer, array $payment)
  {
    try {
      $this->billingType = $payment['method'];
      $this->cycle       = $payment['cycle'];
      $this->customer    = $customer->sku;
      $this->value       = PaymentValue::getValue($this->cycle);
      $this->nextDueDate = Carbon::now()->addDays(3)->format('Y-m-d');
      $this->description = "Aquisição de domicílio fiscal/escritório virtual "  . Carbon::now()->format('Y') .  ".
        Evite cobranças, qualquer problema entre em contato imediatamente com um de nossos atendentes.";
    } catch (\Throwable $th) {
      throw new SubscriptionException('Erro ao criar estrutura de Assinatura que será utilizada no ASAAS', $th->getMessage());
    }
  }
}
