<?php


namespace app;


use Exception;
use Throwable;

class Exception404 extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
