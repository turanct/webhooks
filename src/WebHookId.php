<?php

namespace Turanct\WebHooks;

final class WebHookId
{
    private $id;

    public function __construct($idAsString)
    {
        $this->id = (string) $idAsString;
    }

    public static function generate()
    {
        return new static(uniqid('webhook-', true));
    }

    public function __toString()
    {
        return $this->id;
    }
}
