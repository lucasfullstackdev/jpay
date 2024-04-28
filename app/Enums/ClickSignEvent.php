<?php

namespace App\Enums;

enum ClickSignEvent: string
{
  case ADD_IMAGE = 'add_image';
  case ADD_SIGNER = 'add_signer';
  case ATTEMPTS_BY_WHATSAPP_EXCEEDED = 'attempts_by_whatsapp_exceeded';
  case AUTO_CLOSE = 'auto_close';
  case CANCEL = 'cancel';
  case CLOSE = 'close';
  case CUSTOM = 'custom';
  case DEADLINE = 'deadline';
  case REFUSAL = 'refusal';
  case REMOVE_SIGNER = 'remove_signer';
  case SIGN = 'sign';
  case UPDATE_AUTO_CLOSE = 'update_auto_close';
  case UPDATE_DEADLINE = 'update_deadline';
  case UPLOAD = 'upload';
}
