<?php


namespace app;


class UriFileName
{
    public string $filename;

    /**
     * FileName constructor.
     */
    public function __construct()
    {
        $this->filename = $_SERVER['REQUEST_URI'];
        $this->filename = ltrim($this->filename, '/');
        $this->filename .= '.php';
    }

    /**
     * Exit if PHP-file isn't exists.
     */
    private function selfCheck()
    {
        if (!file_exists($this->filename) || is_dir($this->filename) || !is_readable($this->filename)) {
            (new JsonResponse)
                ->setStatus(404)
                ->setSuccess(false)
                ->sent();
        }
    }
}
