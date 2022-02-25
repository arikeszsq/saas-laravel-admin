<?php
namespace App\Exceptions;
use App\Constants\ResponseCodeConstant;
use Exception;

class ObjectExistException extends Exception
{
    protected $code = ResponseCodeConstant::CONSTANT_RESPONSE_CODE_OBJECT_EXIST;
}
