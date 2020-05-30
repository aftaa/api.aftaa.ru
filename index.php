<?php

// некоторые стартовые магические действия творятся
// в автоматически присоединямом файле auto_prepend_file.php

use app\JsonResponse;
use app\JsonThrowableResponse;
use app\PdoRepository;
use app\TokenAuthentication;
use app\UriFileName;

// все необработанные исключения будут обработаны JsonThrowableResponse
set_exception_handler(function (Throwable $e) {
    (new JsonThrowableResponse)->setException($e)->sent();
});

// внимание, это наше чудо-приложение! содержит конфиг!
$app = (object)[
    'config' => include('app/config.php'),
];

// чудо приложение содержит репозиторий работы с данными, наследуемый от PDO
// и к тому же выбрасывает исключение вместо return false (трижды ура!!!)
$app->pdo = (new PdoRepository($app->config))
    ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// каждый микросервис - это PHP-файл каталога /api/
// самоициниализируется и немножко проверяется на возможность поработать с ним
$filename = new UriFileName;

// аутентификация по токену, имя которого прошито в конфиге
$tokenAuth = new TokenAuthentication($app->config->tokenName);

// до проверки токена глянем, не гламурные ли урлы да айпишники
// попались, которым и аутентификация и вовсе не нужна
if (!$tokenAuth->uriDressCode($filename->filename, $app->config->withoutAuth->uri)
    && !$tokenAuth->ipFaceControl($app->config->withoutAuth->ip)) {
    try {
        if (empty($_SESSION['token'])) {
            throw new Exception;
        }

        $token = $_SESSION['token'];

        $stmt = $app->pdo->prepare('SELECT id FROM token WHERE token=:token AND die<NOW()');
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
