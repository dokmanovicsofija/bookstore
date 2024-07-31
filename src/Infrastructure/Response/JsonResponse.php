<?php

namespace src\Infrastructure\Response;

/**
 * Class JsonResponse
 *
 * Represents a concrete implementation of a response that uses JSON format.
 */
class JsonResponse extends AbstractResponse
{
    /**
     * JsonResponse constructor.
     *
     * @param array $data The data to be sent as JSON response.
     * @param int $statusCode The HTTP status code (default is 200).
     * @param array $headers An associative array of headers (optional).
     */
    public function __construct(private array $data = [], private int $statusCode = 200, private array $headers = []) {}

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function setBody(string $body): void
    {
        // This method is not needed for JSON responses as the body is set directly from data.
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }

        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}