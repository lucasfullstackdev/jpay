<?php

namespace App\Services\Banking\Asaas;

use App\Exceptions\BillingException;
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
  public string $description;
  public float $value = 1200;
  public string $customer;
  public string $dueDate;
  private int $days = 3;

  public function __construct(object $customer)
  {
    try {
      $this->customer = $customer->sku;
      $this->dueDate  = Carbon::now()->addDays($this->days);

      $this->description = "Aquisição de domicílio fiscal/escritório virtual "  . Carbon::now()->format('Y') .  ".
      Evite cobranças, qualquer problema entre em contato imediatamente com um de nossos atendentes.";
    } catch (\Throwable $th) {
      throw new BillingException('Erro ao criar estrutura de Cobrança que será utilizada no ASAAS', $th->getMessage());
    }
  }
}
