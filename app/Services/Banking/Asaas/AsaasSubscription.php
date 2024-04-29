<?php

namespace App\Services\Banking\Asaas;

use App\Enums\Payment\PaymentValue;
use App\Exceptions\SubscriptionException;
use App\Models\Voucher;
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

  public float $valueWithoutDiscount;
  public array $voucher;

  public function __construct(object $customer, array $payment)
  {
    try {
      $this->billingType = $payment['method'];
      $this->cycle       = $payment['cycle'];
      $this->customer    = $customer->sku;
      $this->value       = PaymentValue::getValue($this->cycle);

      // Aplicacao de voucher, se existir
      $voucher = $this->getVoucher($payment['voucher'] ?? null);
      if (!empty($voucher)) {
        $this->voucher = [
          'code' => $voucher->code,
          'percentage' => $voucher->percentage,
        ];

        $this->valueWithoutDiscount = $this->value;
        $this->value = floor($this->value - ($this->value * ($voucher->percentage / 100)));
      }

      $this->nextDueDate = Carbon::now()->addDays(3)->format('Y-m-d');
      $this->description = "Aquisição de domicílio fiscal/escritório virtual "  . Carbon::now()->format('Y') .  ".
        Evite cobranças, qualquer problema entre em contato imediatamente com um de nossos atendentes.";
    } catch (\Throwable $th) {
      throw new SubscriptionException('Erro ao criar estrutura de Assinatura que será utilizada no ASAAS', $th->getMessage());
    }
  }

  private function getVoucher(?string $voucher): ?Voucher
  {
    if (empty($voucher)) {
      return null;
    }

    $voucher = Voucher::where('code', $voucher)->first();

    return $voucher ?? null;
  }
}
