<?php

namespace App\Enums;

enum Person: string
{
  use hasSerialize;

  case PF = 'PF';
  case PJ = 'PJ';
}
