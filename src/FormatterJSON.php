<?php

namespace Turanct\WebHooks;

final class FormatterJSON implements Formatter
{
    public function format(array $data)
    {
        return json_encode($data);
    }

    public function getContentType()
    {
        return 'application/json';
    }
}
