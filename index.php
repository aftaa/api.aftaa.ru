<?php

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', true);

ob_start();

set_exception_handler(function (Throwable $e) {
    echo json_encode((object)[
        'success'   => false,
        'exception' => (object)[
            'message' => $e->getMessage(),
            'code'    => $e->getCode(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ],
        'output'    => ob_get_clean(),
        'status'    => 500,
    ]);
    exit(1);
});

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

($pdo = new PDO('mysql:host=localhost;dbname=aftaa_ru', 'aftaa_ru', 'aftaa_ru', [
    PDO::ATTR_PERSISTENT => true,
]))->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$filename = ltrim($_SERVER['REQUEST_URI'], '/') . '.php';

if (!file_exists($filename) || is_dir($filename) || !is_readable($filename)) {
    header('HTTP/1.0 404 Not Found');
    echo json_encode((object)[
        'success' => false,
        'output'  => ob_get_clean(),
        'status'  => 400,
    ]);
    exit(1);
}

$withoutAuth = [
    'auth/login',
    'auth/logout',
    'data/data-index',
];

if (!in_array($filename, $withoutAuth)) {
    try {
        if (empty($_SESSION['token'])) {
            throw new Exception;
        }

        $token = $_SESSION['token'];

        $stmt = $pdo->prepare('SELECT id FROM token WHERE token=:token AND die<NOW()');
        $stmt->execute([
            'token' => $_SESSION['token'],
        ]);
        if (!$stmt->columnCount()) {
            throw new Exception;
        } else {
            $pdo->prep('UPDATE ');
        }
    } catch (Exception $e) {
        header('401 Unauthorized');
        echo json_encode((object)[
            'success' => false,
            'output'  => ob_get_clean(),
            'status'  => 401,
        ]);
        exit(1);
    }
}

header('200 OK');

echo json_encode((object)[
    'success'  => true,
    'response' => include($filename),
    'output'   => ob_get_clean(),
    'status'   => 200,
]);
