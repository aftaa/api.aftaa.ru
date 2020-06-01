<?php


namespace app;


class CorsPolicy
{
    public array $sitesAvailable;

    /**
     * CorsPolicy constructor.
     * @param array $sitesAvailable
     */
    public function __construct(array $sitesAvailable)
    {
        $this->sitesAvailable = $sitesAvailable;
    }

    public function sentHeaders()
    {
        $header = 'Access-Control-Allow-Origin';
        foreach ($this->sitesAvailable as $site) {
            header("$header: $site", false);
        }
    }

    /**
     * @return array
     */
    public function getSitesAvailable(): array
    {
        return $this->sitesAvailable;
    }

    /**
     * @param array $sitesAvailable
     * @return CorsPolicy
     */
    public function setSitesAvailable(array $sitesAvailable): CorsPolicy
    {
        $this->sitesAvailable = $sitesAvailable;
        return $this;
    }
}
