<?php


namespace app;

/**
 * Class PreAuthentication
 * @package app
 */
class PreAuthentication
{
    public array $configWithoutAuth;

    /**
     * PreAuthentication constructor.
     * @param array $configWithoutAuth
     */
    public function __construct(array $configWithoutAuth)
    {
        $this->configWithoutAuth = $configWithoutAuth;
    }

    /**
     * @return bool
     */
    public function ipFaceControl(): bool
    {
        return in_array($_SERVER['REMOTE_ADDR'], $this->configWithoutAuth->ip);
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function uriDressCode(string $filename): bool
    {
        return in_array($filename, $this->configWithoutAuth->uri);
    }
}
