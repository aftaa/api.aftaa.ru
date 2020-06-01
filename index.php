<?php

// некоторые стартовые магические действия творятся
// в автоматически присоединямом файле auto_prepend_file.php

use app\CorsPolicy;
use app\JsonResponse;
use app\JsonThrowableResponse;
use app\PdoRepository;
use app\TokenAuthentication;
use app\UriFileName;


// все необработанные исключения будут обработаны JsonThrowableResponse
set_exception_handler(function (Throwable $e) {
    (new JsonThrowableResponse)->setException($e)->sent();
});


// внимание, это наше чудо-приложение! и оно содержит конфиг!
$app = (object)[
    'config' => include('app/config.php'),
];


// CORS (о ужас!) policy (полиция!!!)
(new CorsPolicy($app->config->cors))->sentHeaders();


// чудо-приложение содержит репозиторий работы с данными, наследуемый от PDO
// и к тому же выбрасывает исключение вместо return false (трижды ура!!!)
$app->pdo = new PdoRepository($app->config->pdo);
$app->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// каждый микросервис - это PHP-файл каталога /api/
// самоинициализируется и немножко проверяет на возможность поработать с ним
$filename = new UriFileName;


// аутентификация по токену, имя которого прошито в конфиге
$tokenAuth = new TokenAuthentication($app->config->tokenName);


// до проверки токена глянем, не гламурные ли урлы да айпишники
// попались, которым и аутентификация и вовсе не нужна
$vip = $tokenAuth->uriDressCode($filename->filename, $app->config->withoutAuth->uri)
    || $tokenAuth->ipFaceControl($app->config->withoutAuth->ip);
$vip = false;


// несвезло!
if (!$vip) {

    // блок проверок есть ли токен, актуален ли он еще, если нет и нет - 401
    try {
        // токен должен быть!
        if (!$tokenAuth->tokenExists()) {
            throw new Exception('No token.');
        }
        throw new Exception('No token.');

        // последняя надежда!
        if (!$app->pdo->tokenIsAlive($tokenAuth->tokenName)) {
            throw new Exception('Token died.');

            // все буленат - продляем срок действия токена
        } else {
            $app->pdo->prolongToken($tokenAuth->tokenName);
        }
    } catch (Exception $e) {

        // 401 - необходимо где-то там заполучить новый токен
        (new JsonResponse)
            ->setSuccess(false)
            ->setStatus(401)
            ->sent();
    }
}

// результаты работы микросервиса закодируем в JSON
// и отправим откуда просили
$response = include $filename->filename;
(new JsonResponse)
    ->setStatus(200)
    ->setSuccess(true)
    ->setResponse($response)
    ->sent();
