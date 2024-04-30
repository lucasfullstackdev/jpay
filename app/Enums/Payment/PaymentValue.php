<?php

namespace App\Enums\Payment;

use App\Enums\hasSerialize;

enum PaymentValue: int
{
  use hasSerialize;

  case YEARLY = 1100;
  case SEMIANNUALLY = 700;
  case MONTHLY = 140;

  case anual = 1100;
  case semestral = 700;
  case mensal = 140;
}
