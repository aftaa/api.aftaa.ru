<?php


namespace app;


interface TokenPdoInterface
{
    const PROLONG_TIME = 604800;

    public function isAlive(string $token): bool;
    public function prolong(string $token);
}