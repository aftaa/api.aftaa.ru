<?php

ob_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

set_exception_handler(function (Throwable $e) {
    echo json_encode((object)[
        'success'   => false,
        'output'    => ob_get_clean(),
        'exception' => (object)[
            'message' => $e->getMessage(),
            'code'    => $e->getCode(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ],
    ]);
    exit(1);
});

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$pdo = new PDO('mysql:host=localhost;dbname=aftaa_ru', 'aftaa_ru', 'aftaa_ru', [
    PDO::ATTR_PERSISTENT => true,
]);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
