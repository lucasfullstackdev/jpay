<?php

namespace App\Enums;

enum Email: string
{
  use hasSerialize;

  case AUTOMATICO = 'nao-responda@exemplo.com.br';
  case ADMINISTRADOR = 'contato@exemplo.com.br';
  case FINANCEIRO = 'financeiro@exemplo.com.br';
}
