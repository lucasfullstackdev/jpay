<?php

namespace App\Services\Signature\ClickSign;

class ClickSignApiSign
{
  public function __construct(public string $request_signature_key, public string $secret_hmac_sha256)
  {
  }
}
