<?php

namespace App\Enums;

use ReflectionClass;

trait hasSerialize
{
  public static function getValues(): array
  {
    return (new ReflectionClass(__CLASS__))->getConstants();
  }

  public static function getValue(string $key): int|string
  {
    $values = self::getValues();

    if (!array_key_exists($key, $values)) {
      throw new \InvalidArgumentException("Chave não encontrada");
    }

    return $values[$key]->value;
  }
}
