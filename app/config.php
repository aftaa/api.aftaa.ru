<?php

return (object)[
    'pdo' => [
        'dsn'      => 'mysql:host=localhost;dbname=aftaa_ru',
        'username' => 'aftaa_ru',
        'passwd'   => 'aftaa_ru',
        'options'  => [
            PDO::ATTR_PERSISTENT => true,
        ],
    ],
    'withoutAuth' => [
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
    ],
];
