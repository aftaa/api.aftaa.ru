<?php


namespace app;


use PDO;

class PdoRepository extends PDO implements TokenPdoInterface
{
    public object $config;

    public function __construct(object $config)
    {
        parent::__construct(
            $config->pdo->dsn,
            $config->pdo->username,
            $config->pdo->passwd,
            $config->pdo->options,
        );
    }

    /**
     * @param string $token
     * @return bool
     */
    public function isAlive(string $token): bool
    {
        $stmt = $this->prepare('SELECT id FROM token WHERE token=:token AND die > NOW()');
        $stmt->execute([
            'token' => $_SESSION['token'],
        ]);
        return (bool)$stmt->columnCount();
    }

    public function prolong(string $token)
    {
        // TODO: Implement prolong() method.
    }

}
