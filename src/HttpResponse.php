<?php

namespace Turanct\WebHook;

final class Response
{
    private $statusCode;
    private $body;
    private $headers;

    /**
     * @param int $statusCode The status code
     * @param string $body The response body
     * @param array $headers A key => value representation of response headers
     */
    public function __construct($statusCode, $body, array $headers)
    {
        $this->statusCode = (int) $statusCode;
        $this->body = (string) $body;
        $this->headers = $headers;
    }

    /**
     * Returns the statuscode
     *
     * @return int The statuscode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get response body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get Headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
