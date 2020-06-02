<?php

// некоторые стартовые магические действия творятся
// в автоматически присоединямом файле auto_prepend_file.php

use app\AuthenticationService;
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


// блок проверок есть ли токен, актуален ли он еще, если нет и нет - 401
try {
    (new AuthenticationService($app, $filename))->authentication();
} catch (Exception $e) {
    // 401 - необходимо где-то там заполучить новый токен
    (new JsonResponse)
        ->setSuccess(false)
        ->setStatus(401)
        ->sent();
}

// результаты работы микросервиса закодируем в JSON
// и отправим откуда просили
$response = include $filename->filename;
(new JsonResponse)
    ->setStatus(200)
    ->setSuccess(true)
    ->setResponse($response)
    ->sent();
