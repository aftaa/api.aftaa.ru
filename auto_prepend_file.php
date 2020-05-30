<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

ob_start();

function __autoload($class)
{
    $class = str_replace('\\', '/', $class);
    $class .= '.php';
    require $class;
}