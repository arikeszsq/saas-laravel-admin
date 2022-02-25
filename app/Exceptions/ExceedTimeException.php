<?php
namespace App\Exceptions;
use App\Constants\ResponseCodeConstant;
use Exception;

class ExceedTimeException extends Exception
{
    protected $code = ResponseCodeConstant::CONSTANT_RESPONSE_CODE_EXCEED_TIME;
}
