<?php

return (object)[
    'tokenName' => '_44f635f24e1bf9ee80e51287aad0a368+',

    'pdo' => (object)[
        'dsn'      => 'mysql:host=localhost;dbname=aftaa_ru',
        'username' => 'aftaa_ru',
        'passwd'   => 'aftaa_ru',
        'options'  => [
            PDO::ATTR_PERSISTENT => true,
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
            '192.168.1.21',
            '172.16.1.2,',
            '127.0.0.1',
        ],
    ],

    'cors' => [
        'http://aftaa.ru.local',
    ],
];
