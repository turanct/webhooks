<?php

namespace Turanct\WebHooks;

final class WebHooksGeneric implements WebHooks
{
    private $client;
    private $formatter;
    private $signer;

    public function __construct(
        HttpClient $client,
        Formatter $formatter,
        Signer $signer
    ) {
        $this->client = $client;
        $this->formatter = $formatter;
        $this->signer = $signer;
    }

    public function send(WebHook $webhook)
    {
        try {
            $body = $this->formatter->format($webhook->getData());
            $signature = $this->signer->sign($body, $webhook->getVerification());

            $request = new HttpRequest(
                'POST',
                $webhook->getUrl(),
                array(),
                array(
                    'Content-Type' => $this->formatter->getContentType(),
                    'X-Signature' => $signature,
                    'X-Id' => (string) $webhook->getId(),
                ),
                $body
            );

            $this->client->execute($request);
        } catch (HttpClientException $e) {
            throw new WebHookWasNotSent('Webhook was not sent: connection failed', 0, $e);
        }
    }
}
