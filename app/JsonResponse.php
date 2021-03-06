<?php


namespace app;


class JsonResponse
{
    const HTTP_CODES = [
        200 => '200 OK',
        401 => '401 Unauthorized',
        404 => '404 Not Found',
        500 => '500 Internal Server Error',
    ];

    private bool $success;
    private int $status;

    /** @var mixed */
    private $response;

    /**
     * JsonResponse constructor.
     */
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    /**
     * Send the header and the JSON response.
     * Exit the program.
     */
    public function send()
    {
        $this->sendHeader();

        echo json_encode((object)[
            'success'  => $this->success,
            'response' => $this->response,
            'output'   => ob_get_clean(),
            'status'   => $this->status,
        ]);

        exit;
    }

    /**
     * @param bool $success
     * @return JsonResponse
     */
    public function setSuccess(bool $success): JsonResponse
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @param int $status
     * @return JsonResponse
     */
    public function setStatus(int $status): JsonResponse
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param mixed $response
     * @return JsonResponse
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Send the header.
     */
    protected function sendHeader()
    {
        if (array_key_exists($this->status, self::HTTP_CODES)) {
            $header = self::HTTP_CODES[$this->status];
            header($header, true, $this->status);
        }
    }
}
