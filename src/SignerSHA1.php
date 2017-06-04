<?php

namespace Turanct\WebHooks;

final class SignerSHA1 implements Signer
{
    public function sign($data, $secret)
    {
        return hash_hmac('sha1', $data, $secret),
    }
}
