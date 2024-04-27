<?php

namespace App\Enums\Payment;

use App\Enums\hasSerialize;

enum PaymentMethod: string
{
  use hasSerialize;

  case BOLETO = 'BOLETO';
  case UNDEFINED = 'UNDEFINED';
}
