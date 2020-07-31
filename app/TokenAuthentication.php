<?php


namespace app;

use Exception;

/**
 * Class TokenAuthentication
 * @package app
 */
class TokenAuthentication
{
    public object $app;
    public string $tokenName;
    public PdoRepository $pdo;

    /**
     * TokenAuthentication constructor.
     * @param object $app
     */
    public function __construct(object $app)
    {
        $this->app = $app;
        $this->tokenName = $this->app->config->tokenName;
        $this->pdo = $this->app->pdo;
    }

    /**
     * @throws Exception
     */
    public function authenticate()
    {
        // аутентификация по токену, имя которого прошито в конфиге

        // токен должен быть!
        if (!$this->sessionTokenExists()) {
            throw new Exception('No token.');
        }

        // последняя надежда!
        if (!$this->pdo->tokenIsAlive($this->tokenName)) {
            throw new Exception('Token died.');
        }
    }

    /**
     * @return bool
     */
    private function sessionTokenExists(): bool
    {
        return array_key_exists($this->tokenName, $_SESSION);
    }
}
