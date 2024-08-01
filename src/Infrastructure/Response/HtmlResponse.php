<?php

namespace src\Infrastructure\Response;

use Exception;

/**
 * Class HtmlResponse
 *
 * Represents a Html response. It provides methods to set the status code, headers, and body of the response
 * and to send the response to the client.
 */
class HtmlResponse extends AbstractHttpResponse
{
    /**
     * HtmlResponse constructor.
     *
     * @param int $statusCode The HTTP status code for the response (default is 200).
     * @param string $body The body content of the response (default is an empty string).
     * @param array $headers An associative array of headers to include in the response (default is an empty array).
     */
    public function __construct(private int $statusCode = 200, private string $body = '', private array $headers = [])
    {
    }

    /**
     * Sets the HTTP status code for the response.
     *
     * @param int $statusCode The HTTP status code to set.
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Adds a header to the response.
     *
     * @param string $name The name of the header.
     * @param string $value The value of the header.
     */
    public function addHeader(string $name, string $value): void
    {
        $this->headers[] = [$name => $value];
    }

    /**
     * Sets the body content of the response.
     *
     * @param string $body The body content to set.
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Load content from an HTML file and set it as the body of the response.
     *
     * @param string $filePath The path to the HTML file.
     * @param array $data An associative array of data to be used in the view (optional).
     * @throws Exception
     */
    public function setBodyFromFile(string $filePath, array $data = []): void
    {
        if (file_exists($filePath)) {
            ob_start();
            extract($data);
            include $filePath;
            $this->body = ob_get_clean();
        } else {
            throw new Exception("File not found: $filePath");
        }
    }

    /**
     * Sends the HTTP response to the client.
     *
     * This method sets the HTTP status code, adds the headers, and outputs the body content.
     */
    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        echo $this->body;
    }
}
