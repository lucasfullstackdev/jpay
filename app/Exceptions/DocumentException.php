<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class DocumentException extends CustomException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
