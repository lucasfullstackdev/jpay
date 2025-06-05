<?php

namespace App\Enums;

enum SignerAuth: string
{
  case EMAIL = 'email';
  case SMS = 'sms';
  case WHATSAPP = 'whatsapp';
  case PIX = 'pix';
  case API = 'api';
  case ICP_BRASIL = 'icp_brasil';
}
