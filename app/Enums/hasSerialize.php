<?php

namespace App\Enums;

use ReflectionClass;

trait hasSerialize
{
  public static function getValues(): array
  {
    $reflection = new ReflectionClass(__CLASS__);
    return array_values($reflection->getConstants());
  }
}
