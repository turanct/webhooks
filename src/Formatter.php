<?php

namespace Turanct\WebHooks;

interface Formatter
{
    /**
     * Format the given data to be sent over HTTP
     *
     * @param array $data The data that we're formatting
     *
     * @return string The formatted data as a string
     */
    public function format(array $data);

    /**
     * Get the content type that we're formatting to
     *
     * @return string The Content Type for the formatted data
     */
    public function getContentType();
}
