<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CustomerException extends CustomException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
