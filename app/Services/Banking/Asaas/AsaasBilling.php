<?php

namespace App\Services\Banking\Asaas;

use App\Services\Banking\CustomerInterface;
use Carbon\Carbon;

class AsaasBilling implements CustomerInterface
{
  /**
   * - BillingType precisa ser undefined para que o ASAAS possa 
   *   fornecer todas as opcoes de pagamento disponiveis
   * 
   * - Por enquanto o campo VALUE vai ser estático pois o objetivo aqui
   *   é fazer a api rodar e só depois melhorar
   */
  public string $billingType = "UNDEFINED";
  public float $value = 1200;
  public string $customer;
  public string $dueDate;
  private int $days = 3;

  public function __construct(object $customer)
  {
    $this->customer = $customer->sku;
    $this->dueDate  = Carbon::now()->addDays($this->days);
  }
}
