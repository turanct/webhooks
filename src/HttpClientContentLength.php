<?php

namespace Turanct\WebHooks;

final class HttpClientContentLength
{
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(HttpRequest $request)
    {
        $body = $request->getBody();
        $length = mb_strlen($body);

        $request = $request->addHeader('Content-Length', $length);

        $response = $this->client->execute($request);

        return $response;
    }
}
