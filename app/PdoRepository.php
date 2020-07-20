<?php


namespace app;


use PDO;

class PdoRepository extends PDO implements TokenMethodsInterface
{
    public object $config;

    public function __construct(object $config)
    {
        parent::__construct(
            $config->dsn,
            $config->username,
            $config->passwd,
            $config->options,
        );
    }

    /**
     * @param string $token
     * @return bool
     */
    public function tokenIsAlive(string $token): bool
    {
        $stmt = $this->prepare('DELETE FROM token WHERE token=:token AND die <= NOW()');
        $stmt->execute([
            'token' => $_SESSION['token'],
        ]);
        return (bool)$stmt->columnCount();
    }

    /**
     * @param string $token
     */
    public function prolongToken(string $token): void
    {
        $stmt = $this->prepare('UPDATE token SET die = die + :prolong WHERE token=:token');
        $stmt->execute([
            'token' => $token,
            'prolong' => self::PROLONG_TIME,
        ]);

    }

}
