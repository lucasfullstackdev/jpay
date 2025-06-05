<?php

namespace App\Exceptions\CMS;

use App\Exceptions\CustomException;
use Symfony\Component\HttpFoundation\Response;

class ActiveUserException extends CustomException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
