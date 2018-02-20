<?php

namespace Turanct\WebHooks;

final class HttpClientFileGetContents implements HttpClient
{
    public function execute(HttpRequest $request)
    {
        $headers = '';
        foreach ($request->getHeaders() as $key => $value) {
            $headers .= "{$key}: {$value}\r\n";
        }

        var_dump($headers);

        $opts = array(
            'http' => array(
                'method'  => $request->getMethod(),
                'header' => $headers,
                'content' => $request->getBody()
            ),
        );

        $context  = stream_context_create($opts);

        $result = file_get_contents($request->getUrl(), false, $context);
        if ($result === false) {
            throw new HttpClientException('Connection failed');
        }
        return new HttpResponse($http_response_header[0], $result, $http_response_header ?: array());
    }
}
