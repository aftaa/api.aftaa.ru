<?php


namespace app;


use Throwable;

class JsonThrowableResponse extends JsonResponse
{
    private Throwable $e;

    /**
     * @param Throwable $e
     * @return JsonThrowableResponse
     */
    public function setException(Throwable $e): JsonThrowableResponse
    {
        $this->e = $e;
        return $this;
    }
    
    /**
     * @inheritDoc
     */
    public function sent()
    {
        $this->setStatus(500)->sentHeader();

        echo json_encode((object)[
            'success'   => false,
            'exception' => (object)[
                'message' => $this->e->getMessage(),
                'code'    => $this->e->getCode(),
                'file'    => $this->e->getFile(),
                'line'    => $this->e->getLine(),
            ],
            'output'    => ob_get_clean(),
            'status'    => 500,
        ]);

        exit(1);
    }
}