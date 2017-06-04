<?php

namespace Turanct\WebHooks;

final class HttpClientUserAgent
{
    private $client;
    private $userAgent;

    public function __construct(HttpClient $client, $userAgent)
    {
        $this->client = $client;
        $this->userAgent = (string) $userAgent;
    }

    public function execute(HttpRequest $request)
    {
        $request = $request->addHeader('User-Agent', $this->userAgent);

        $response = $this->client->execute($request);

        return $response;
    }
}
