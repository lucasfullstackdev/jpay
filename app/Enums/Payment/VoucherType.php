<?php

namespace App\Enums\Payment;

use App\Enums\hasSerialize;

enum VoucherType: string
{
  use hasSerialize;

  case PERPETAL = 'perpetal';
  case ONE_TIME = 'one_time';
}
