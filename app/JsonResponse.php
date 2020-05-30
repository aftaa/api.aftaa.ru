<?php


namespace app;


class JsonResponse
{
    const HTTP_CODES = [
        200 => 'HTTP/1.0 OK',
        401 => 'HTTP/1.0 Unauthorized',
        404 => 'HTTP/1.0 Not Found',
        500 => 'HTTP/1.0 Internal Server Error',
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
     * Sent the header and the JSON response.
     * Exit the program.
     */
    public function sent()
    {
        $this->sentHeader();

        echo json_encode((object)[
            'success'  => $this->success,
            'response' => $this->response,
            'output'   => ob_get_clean(),
            'status'   => $this->status,
        ]);

        exit(200 != $this->status);
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
     * Sent the header.
     */
    protected function sentHeader()
    {
        if (array_key_exists($this->status, self::HTTP_CODES)) {
            $header = self::HTTP_CODES[$this->status];
            header($header, true, $this->status);
        }
    }
}
