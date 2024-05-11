<?php

namespace App\Enums;

enum Email: string
{
  use hasSerialize;

  case AUTOMATICO = 'nao-responda@oshicoworking.com.br';
  case ADMINISTRADOR = 'contato@jellycode.com.br';
  case FINANCEIRO = 'financeiro@oshicoworking.com.br';
}
