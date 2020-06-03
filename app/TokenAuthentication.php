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

    /**
     * TokenAuthentication constructor.
     * @param object $app
     */
    public function __construct(object $app)
    {
        $this->app = $app;
        $this->tokenName = $this->app->config->tokenName;
    }

    /**
     * @throws Exception
     */
    public function authenticate()
    {
        // аутентификация по токену, имя которого прошито в конфиге

        // токен должен быть!
        if (!$this->tokenExists()) {
            throw new Exception('No token.');
        }

        // последняя надежда!
        if (!$this->app->pdo->tokenIsAlive($this->tokenName)) {
            throw new Exception('Token died.');
        }

        // все буленат! - продляем срок действия токена
    }

    /**
     * @return bool
     */
    private function tokenExists(): bool
    {
        return array_key_exists($this->tokenName, $_SESSION);
    }
}
