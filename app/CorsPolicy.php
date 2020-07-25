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

    public function sendHeaders()
    {
        $origin = $_SERVER['HTTP_ORIGIN'];
        if (in_array($origin, $this->allowedSites)) {
            header("Access-Control-Allow-Origin: $origin");
        }

//        $header = 'Access-Control-Allow-Origin';
//        $allowedSites = implode(', ', $this->allowedSites);
//        header("$header: $allowedSites");
//        foreach ($this->allowedSites as $site) {
//            header("$header: $site", false);
//        }
	
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
