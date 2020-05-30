<?php

return (object)[
    'pdo' => [
        'dsn'      => 'mysql:host=localhost;dbname=aftaa_ru',
        'user'     => 'aftaa_ru',
        'password' => 'aftaa_ru',
        'options'  => [
            PDO::ATTR_PERSISTENT => true,
        ],
    ],
];
