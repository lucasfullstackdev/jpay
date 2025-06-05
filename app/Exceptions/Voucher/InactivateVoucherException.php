<?php

namespace App\Exceptions\Voucher;

use App\Exceptions\CustomException;
use Symfony\Component\HttpFoundation\Response;

class InactivateVoucherException extends CustomException
{
  protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
