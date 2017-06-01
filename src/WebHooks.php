<?php

namespace Turanct\WebHooks;

interface WebHooks
{
    /**
     * Send a webhook
     *
     * @throws WebHookWasNotSent exception when we could not send
     *
     * @param WebHook $webhook The webhook we want to send
     * */
    public function send(WebHook $webhook);
}
