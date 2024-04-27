<?php

namespace App\Enums\Payment;

use App\Enums\hasSerialize;

enum PaymentCycle: string
{
  use hasSerialize;

  case YEARLY = 'YEARLY';
  case SEMIANNUALLY = 'SEMIANNUALLY';
  case MONTHLY = 'MONTHLY';
}
