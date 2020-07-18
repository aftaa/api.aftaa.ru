<?php


namespace app;

use Exception;

/**
 * Class AuthenticationService
 * @package app
 */
class AuthenticationService
{
    public object $app;
    public UriFileName $filename;

    /**
     * AuthenticationService constructor.
     * @param object $app
     * @param UriFileName $filename
     */
    public function __construct(object $app, UriFileName $filename)
    {
        $this->app = $app;
        $this->filename = $filename;

        // CORS policy
        (new CorsPolicy($app->config->allowedSites))
            ->sendHeaders();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function authenticate(): bool
    {
        // авторизация №1
        if ($this->app->config->debug->vipAuth) { // TODO debug
            (new VipAuthentication($this->app->config->withoutAuth, $this->filename->filename))
                ->authenticate();
        }

        // авторизация №2
        if ($this->app->config->debug->tokenAuth) { // TODO debug
            (new TokenAuthentication($this->app))
                ->authenticate();
        }

        // авторизация №3
        if ($this->app->config->debug->userAuth) { // TODO debug
            (new UserAuthentication)
                ->authenticate();
        }

        return true;
    }

    /**
     *
     */
    public function prolongToken(): void
    {
        $this->app->pdo->prolongToken($this->app->config->tokenName);
    }
}
