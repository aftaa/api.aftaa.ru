<?php


namespace app;


use PDO;

class PdoRepository extends PDO
{
    public function __construct(object $config)
    {
        parent::__construct(
            $config->dsn,
            $config->username,
            $config->passwd,
            $config->options,
        );
    }
}
