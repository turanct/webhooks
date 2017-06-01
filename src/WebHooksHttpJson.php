<?php

namespace Turanct\WebHooks;

final class WebHooksHttpJson implements WebHooks
{
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function send(WebHook $webhook)
    {
        try {
            $body = json_encode($webhook->getData());

            $request = new HttpRequest(
                'POST',
                $webhook->getUrl(),
                array(),
                array(
                    'User-Agent' => 'Turanct/WebHooks',
                    'Content-Type' => 'application/json',
                    'Content-Length' => mb_strlen($body),
                    'X-Signature' => hash_hmac('sha1', $body, $webhook->getVerification()),
                ),
                $body
            );

            $this->client->execute($request);
        } catch (HttpClientException $e) {
            throw new WebHookWasNotSent('Webhook was not sent: connection failed', 0, $e);
        }
    }
}
