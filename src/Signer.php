<?php

namespace Turanct\WebHooks;

interface Signer
{
    /**
     * Sign a string with a given verification "secret"
     *
     * @param string $data The data that we're signing
     * @param string $secret The secret to sign with
     *
     * @return string The calculated signature
     */
    public function sign($data, $secret);
}
