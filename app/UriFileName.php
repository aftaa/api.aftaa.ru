<?php


namespace app;


class UriFileName
{
    public string $filename;

    /**
     * FileName constructor.
     * @throws Exception404
     */
    public function __construct()
    {
        // каждый микросервис - это PHP-файл каталога /api/
        // самоинициализируется и немножко проверяет на возможность поработать с ним
        $this->filename = $_SERVER['REQUEST_URI'];
        $this->filename = ltrim($this->filename, '/');
        $this->filename .= '.php';

        $this->selfCheck();
    }

    /**
     * Exit if PHP-file isn't exists.
     * @throws Exception404
     */
    private function selfCheck()
    {
        if (!file_exists($this->filename) || is_dir($this->filename) || !is_readable($this->filename)) {
            throw new Exception404("File $this->filename not found.");
        }
    }
}
