<?php

require_once 'app/JsonResponse.php';
require_once 'app/JsonThrowableResponse.php';

use app\JsonResponse;
use app\JsonThrowableResponse;

error_reporting(E_ALL);
ini_set('display_errors', true);

ob_start();

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

set_exception_handler(function (Throwable $e) {
    (new JsonThrowableResponse)->setException($e)->sent();
});

($pdo = new PDO('mysql:host=localhost;dbname=aftaa_ru', 'aftaa_ru', 'aftaa_ru', [
    PDO::ATTR_PERSISTENT => true,
]))->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$filename = ltrim($_SERVER['REQUEST_URI'], '/') . '.php';

if (!file_exists($filename) || is_dir($filename) || !is_readable($filename)) {

    (new JsonResponse)
        ->setStatus(404)
        ->setSuccess(false)
        ->sent();
}

$withoutAuth = [
    'uri' => [
        'api/auth/login.php',
        'api/auth/logout.php',
        'api/data/index-data.php',
    ],
    'ip'  => [
        '128.0.142.30',
        '192.168.1.21',
        '172.16.1.2,',
        '127.0.0.1',
    ],
];

if (!in_array($filename, $withoutAuth['uri']) && !in_array($_SERVER['REMOTE_ADDR'], $withoutAuth['ip'])) {
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
            $pdo
                ->prepare('UPDATE token SET die=NOW()+604800 WHERE token=:token')
                ->execute([
                    'token' => $token,
                ]);
        }
    } catch (Exception $e) {
        (new JsonResponse)
            ->setSuccess(false)
            ->setStatus(401)
            ->sent();

    }
}

(new JsonResponse)
    ->setStatus(200)
    ->setSuccess(true)
    ->setResponse(include $filename)
    ->sent();