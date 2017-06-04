<?php

namespace Turanct\WebHooks;

final class HttpRequest
{
    private $method;
    private $url;
    private $params;
    private $headers;
    private $body;

    /**
     * @param string $method An HTTP method like GET, POST,...
     * @param string $url The url to make an HTTP request to
     * @param array $params A list of HTTP parameters in key/value style
     * @param array $headers A list of HTTP headers in key/value style
     * @param mixed $body A body payload to send
     */
    public function __construct($method, $url, array $params = array(), array $headers = array(), $body = null)
    {
        $this->method = (string) $method;
        $this->url = (string) $url;
        $this->params = $params;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function addHeader($name, $value)
    {
        $headers = $this->headers;
        $headers[(string) $name] = (string) $value;

        return new static(
            $this->method,
            $this->url,
            $this->params,
            $headers,
            $this->body
        );
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }
}
