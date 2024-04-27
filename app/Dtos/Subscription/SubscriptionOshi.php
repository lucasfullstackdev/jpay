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
  public ?string $description;
  public string $subscription;

  public function __construct(object $subscription)
  {
    try {
      $this->sku = $subscription->id;
      $this->customer = $subscription->customer;
      $this->value = $subscription->value;
      $this->cycle = $subscription->cycle;
      $this->description = $subscription->description;
      $this->subscription = json_encode($subscription);
    } catch (\Throwable $th) {
      throw new SubscriptionException('Erro ao criar a estrutura de dados para salvar a Subscription no banco de dados',  $th->getMessage(), (array) $subscription);
    }
  }
}
