<?php

namespace src\Infrastructure\Response;

/**
 * Class JsonResponse
 *
 * Represents a concrete implementation of a response that uses JSON format.
 */
class JsonResponse extends AbstractHttpResponse
{
    /**
     * JsonResponse constructor.
     *
     * @param array $data The data to be sent as JSON response.
     * @param int $statusCode The HTTP status code (default is 200).
     * @param array $headers An associative array of headers (optional).
     */
    public function __construct(private array $data = [], private int $statusCode = 200, private array $headers = [])
    {
    }

    /**
     * Set the HTTP status code for the response.
     *
     * @param int $statusCode The HTTP status code.
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Add a header to the response.
     *
     * @param string $name The name of the header.
     * @param string $value The value of the header.
     */
    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * Set the body of the response.
     *
     * @param string $body The body content (which would override the JSON data in this case).
     */
    public function setBody(string $body): void
    {
        $this->data = json_decode($body, true);
    }

    /**
     * Send the JSON response to the client.
     */
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