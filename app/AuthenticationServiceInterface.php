<?php


namespace app;


use Exception;

interface AuthenticationServiceInterface
{
    /**
     * @throws Exception
     */
    public function authentication(): void;

    public function preAuthentication(): void;
    public function TokenAuthentication(): void;
    public function UserAuthentication(): void;

}