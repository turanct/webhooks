<?php

namespace Turanct\WebHooks;

final class WebHook
{
    private $url;
    private $verification;
    private $data;

    public function __construct($url, $verification, array $data)
    {
        $this->url = (string) $url;
        $this->verification = (string) $verification;
        $this->data = $data;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getVerification()
    {
        return $this->verification;
    }

    public function getData()
    {
        return $this->data;
    }
}
