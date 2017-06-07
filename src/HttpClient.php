<?php

namespace Turanct\WebHooks;

interface HttpClient
{
    /**
     * @param HttpRequest $request An HTTP method like GET, POST,...
     *
     * @throws HttpClientException if the connection failed
     *
     * @return HttpResponse a response instance
     */
    public function execute(HttpRequest $request);
}
