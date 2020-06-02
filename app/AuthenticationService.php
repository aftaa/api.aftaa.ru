<?php


namespace app;

/**
 * Class AuthenticationService
 * @package app
 */
class AuthenticationService implements AuthenticationServiceInterface
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
        // каждый микросервис - это PHP-файл каталога /api/
        // самоинициализируется и немножко проверяет на возможность поработать с ним
        $this->filename = new UriFileName;


    }

    public function authentication(): void
    {
        $pseudoVip = $this->preAuthentication();
        // несвезло или свезло!
        if (!$pseudoVip || $this->config->debug->vipReset) {

            $tokenAuth = new TokenAuthentication;

            // токен должен быть!
            if (!$tokenAuth->tokenExists()) {
                throw new Exception('No token.');
            }


            // последняя надежда!
            if (!$app->pdo->tokenIsAlive($tokenAuth->tokenName)) {
                throw new Exception('Token died.');

                // все буленат - продляем срок действия токена
            } else {
                $app->pdo->prolongToken($tokenAuth->tokenName);
            }
        }
    }

    public function preAuthentication(): bool
    {
        // аутентификация по токену, имя которого прошито в конфиге
        $preAuth = new PreAuthentication($this->app->confif->tokenName);

        // до проверки токена глянем, не гламурные ли урлы да айпишники
// попались, которым и аутентификация и вовсе не нужна
        $pseudoVip = $preAuth->uriDressCode($filename->filename, $app->config->withoutAuth->uri)
            || $preAuth->ipFaceControl($app->config->withoutAuth->ip);

        return $pseudoVip;
    }
}