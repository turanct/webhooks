<?php

namespace Turanct\WebHooks;

final class SignerSHA256 implements Signer
{
    public function sign($data, $secret)
    {
        return hash_hmac('sha256', $data, $secret);
    }
}
