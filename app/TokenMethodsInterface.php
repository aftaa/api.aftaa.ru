<?php


namespace app;


interface TokenMethodsInterface
{
    const PROLONG_TIME = 604800;

    public function tokenIsAlive(string $tokenName): bool;
    public function prolongToken(string $tokenName): void;
}
