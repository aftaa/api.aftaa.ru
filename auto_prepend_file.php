<?php

// максимальный вывод ошибок в вывод
error_reporting(E_ALL);
ini_set('display_errors', true);

// все (PHP и пользовательские) ошибки переводим в исключения (ура!)
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

/**
 * deprecated магический метод автозагрузки файлов, но нам большего и не нужно
 * @param string $class
 */
function __autoload(string $class)
{
    require str_replace('\\', '/', $class) . '.php';
}

// начинаем перехват выходного потока
ob_start();
