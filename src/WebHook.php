<?php

namespace Turanct\WebHooks;

final class WebHook
{
    private $id;
    private $url;
    private $verification;
    private $data;

    public function __construct(WebHookId $id, $url, $verification, array $data)
    {
        $this->id = $id;
        $this->url = (string) $url;
        $this->verification = (string) $verification;
        $this->data = $data;
    }

    public function getId()
    {
        return $this->id;
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
