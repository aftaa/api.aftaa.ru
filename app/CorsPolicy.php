<?php


namespace app;


class CorsPolicy
{
    public array $allowedSites;

    /**
     * CorsPolicy constructor.
     * @param array $allowedSites
     */
    public function __construct(array $allowedSites)
    {
        $this->allowedSites = $allowedSites;
    }

    public function sentHeaders()
    {
        $header = 'Access-Control-Allow-Origin';
        foreach ($this->allowedSites as $site) {
            header("$header: $site", false);
        }
    }

    /**
     * @return array
     */
    public function getAllowedSites(): array
    {
        return $this->allowedSites;
    }

    /**
     * @param array $allowedSites
     * @return CorsPolicy
     */
    public function setAllowedSites(array $allowedSites): CorsPolicy
    {
        $this->allowedSites = $allowedSites;
        return $this;
    }
}
