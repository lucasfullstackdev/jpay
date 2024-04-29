<?php

namespace App\Dtos\Subscription;

use App\Exceptions\SubscriptionException;
use App\Services\Banking\CustomerInterface;

class SubscriptionOshi implements CustomerInterface
{
  public string $sku;
  public string $customer;
  public float $value;
  public string $cycle;
  public string $billing_type;
  public ?string $description;
  public string $subscription;

  // Caso seja aplicado desconto através de voucher
  public ?float $value_without_discount;
  public ?string $voucher = null;

  public function __construct(object $subscription)
  {
    try {
      $this->sku = $subscription->id;
      $this->customer = $subscription->customer;
      $this->value = $subscription->value;
      $this->cycle = $subscription->cycle;
      $this->billing_type = $subscription->billingType;
      $this->description = $subscription->description;
      $this->subscription = json_encode($subscription);

      $this->value_without_discount = $subscription->valueWithoutDiscount ?? null;
      if (!empty($subscription->voucher)) {
        $this->voucher = json_encode($subscription->voucher);
      }
    } catch (\Throwable $th) {
      throw new SubscriptionException('Erro ao criar a estrutura de dados para salvar a Subscription no banco de dados',  $th->getMessage(), (array) $subscription);
    }
  }
}
