<?php

namespace App\Enums\Payment;

use App\Enums\hasSerialize;

enum PaymentCycle: string
{
  use hasSerialize;

  case MONTHLY = 'MONTHLY';
  case YEARLY = 'YEARLY';
}
