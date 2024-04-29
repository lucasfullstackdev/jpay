<?php

namespace App\Enums\CMS;

enum CMSPostStatus: string
{
  case PUBLISH = 'publish';
  case DRAFT = 'draft';
}
