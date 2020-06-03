<?php


namespace app;

use Exception;

/**
 * Class PreAuthentication
 * @package app
 */
class VipAuthentication
{
    public array $withoutAuth;
    public string $filename;

    /**
     * VipAuthentication constructor.
     * @param array $withoutAuth
     * @param string $filename
     */
    public function __construct(array $withoutAuth, string $filename)
    {
        $this->withoutAuth = $withoutAuth;
        $this->filename = $filename;
    }

    /**
     * @throws Exception
     */
    public function authenticate(): void
    {
        // до проверки токена глянем, не гламурные ли урлы да айпишники
        // попались, которым и аутентификация и вовсе не нужна
        $vip = $this->ipFaceControl() || $this->uriDressCode();

        // несвезло или или свезло?! :)
        if (!$vip) {
            throw new Exception('VIP auth failed.');
        }
    }

    /**
     * @return bool
     */
    public function ipFaceControl(): bool
    {
        echo "<pre>"; print_r(1); echo "</pre>"; die;
        return in_array($_SERVER['REMOTE_ADDR'], $this->withoutAuth->ip);
    }

    /**
     * @return bool
     */
    public function uriDressCode(): bool
    {
        echo "<pre>"; print_r(2); echo "</pre>"; die;
        return in_array($this->filename, $this->withoutAuth->uri);
    }
}
