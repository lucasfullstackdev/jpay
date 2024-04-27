<?php

namespace App\Dtos\Subscription;

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
    $this->sku = $subscription->id;
    $this->customer = $subscription->customer;
    $this->value = $subscription->value;
    $this->cycle = $subscription->cycle;
    $this->description = $subscription->description;
    $this->subscription = json_encode($subscription);
  }
}
