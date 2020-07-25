<?php

return (object)[
    'tokenName' => '_44f635f24e1bf9ee80e51287aad0a368+',

    'debug' => (object)[
        'vipAuth' => true,
        'tokenAuth' => false,
        'useTestToken' => false,
        'testToken' => '',
        'userAuth' => false,
    ],

    'allowedSites' => [
        'https://aftaa.ru',
	'http://aftaa.ru.local',
    ],

    'pdo' => (object)[
        'dsn'      => 'mysql:host=localhost;dbname=aftaa_ru',
        'username' => 'aftaa_ru',
        'passwd'   => 'aftaa_ru',
        'options'  => [
//            PDO::ATTR_PERSISTENT => true,
        ],
    ],

    'withoutAuth' => (object)[
        'uri' => [
            'api/auth/login.php',
            'api/auth/logout.php',
            'api/data/index-data.php',
        ],

        'ip' => [
            '128.0.142.30',
            '127.0.0.1',
        ],
    ],
];
