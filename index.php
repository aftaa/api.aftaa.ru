<?php

// некоторые стартовые магические действия творятся
// в автоматически присоединямом файле auto_prepend_file.php

use app\AuthenticationService;
use app\CorsPolicy;
use app\Exception401;
use app\Exception404;
use app\JsonResponse;
use app\JsonThrowableResponse;
use app\PdoRepository;
use app\UriFileName;


// все необработанные исключения будут обработаны JsonThrowableResponse
set_exception_handler(function (Throwable $e) {
    (new JsonThrowableResponse)->setException($e)->send();
});


// внимание, это наше чудо-приложение! и оно содержит конфиг!
$app = (object)[
    'config' => include('app/config.php'),
];


// CORS policy (запускаем здесь, а не где-то там, чтобы все работало)
(new CorsPolicy($app->config->allowedSites))->sendHeaders();


// чудо-приложение содержит репозиторий работы с данными, наследуемый от PDO
// и к тому же выбрасывает исключение вместо return false (трижды ура!!!)
$app->pdo = new PdoRepository($app->config->pdo);
$app->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// блок проверок есть ли токен, актуален ли он еще, если нет и нет - 401
try {

    $filename = new UriFileName;

    $authenticationService = new AuthenticationService(
        $app, $filename,
    );

    if ($authenticationService->authenticate()) {
        $authenticationService->prolongToken();
    }

    // результаты работы микросервиса закодируем в JSON
    // и отправим откуда спрашивали
    $response = include $filename->filename;
    echo "<pre>"; print_r($response); echo "</pre>";die;

    (new JsonResponse)
        ->setStatus(200)
        ->setSuccess(true)
        ->setResponse($response)
        ->send();
} catch (Exception401|Exception404 $e) {
    (new JsonResponse)
        ->setSuccess(false)
        ->setStatus($e->getCode()) // Exception401 | Exception 404
        ->send();

} catch (Exception $e) {
    (new JsonThrowableResponse)
        ->setException($e)
        ->send();
}
