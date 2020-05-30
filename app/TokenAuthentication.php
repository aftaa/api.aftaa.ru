<?php


namespace app;


class TokenAuthentication
{
    public string $tokenName;

    /**
     * TokenAuthentication constructor.
     * @param string $tokenName
     */
    public function __construct(string $tokenName)
    {
        $this->tokenName = $tokenName;
    }

    /**
     * @return bool
     */
    public function tokenExists(): bool
    {
        return array_key_exists($this->tokenName, $_SESSION);
    }

    /**
     * @param array $ip
     * @return bool
     */
    public function ipFaceControl(array $ip): bool
    {
        return in_array($_SERVER['REMOTE_ADDR'], $ip);
    }

    /**
     * @param string $filename
     * @param array $uri
     * @return bool
     */
    public function uriDressCode(string $filename, array $uri): bool
    {
        return in_array($filename, $uri);
    }
}
