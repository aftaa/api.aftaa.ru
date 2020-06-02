<?php


namespace app;

/**
 * Class TokenAuthentication
 * @package app
 */
class TokenAuthentication extends PreAuthentication
{
    /**
     * @return bool
     */
    public function tokenExists(): bool
    {
        return array_key_exists($this->config->tokenName, $_SESSION);
    }
}
