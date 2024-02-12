<?php

namespace App\Dtos\Billing;

use App\Services\Banking\CustomerInterface;

class BillingOshi implements CustomerInterface
{
  public string $sku;
  public string $customer;
  public string $value;
  public string $net_value;
  public string $billing_type;
  public string $due_date;
  public string $invoice_url;
  public string $invoice_number;

  public function __construct(object $billing)
  {
    $this->sku = $billing->id;
    $this->customer = $billing->customer;
    $this->value = $billing->value;
    $this->net_value = $billing->netValue;
    $this->billing_type = $billing->billingType;
    $this->due_date = $billing->dueDate;
    $this->invoice_url = $billing->invoiceUrl;
    $this->invoice_number = $billing->invoiceNumber;
  }
}
