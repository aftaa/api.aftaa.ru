<?php


namespace app;


use Exception;
use Throwable;

class Exception401 extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, 401, $previous);
    }
}
