# WebHooks

[![Travis CI](https://api.travis-ci.org/turanct/webhooks.svg?branch=master)](https://travis-ci.org/turanct/webhooks)


## Goal

Create a very simple and easy to use library that triggers webhooks.


## Basic Usage

The main interface that this package provides is the [`WebHooks` interface](/src/WebHooks.php). It provides a single method `send()` which takes a `WebHook` instance and sends it. You can then configure your Dependency Injection Container or Service Locator to build the specific implementation of that interface, depending on your needs. Let's see how you'd use this in a dummy controller:

```php
<?php

use Turanct\WebHooks\WebHooks;
use Turanct\WebHooks\WebHook;
use Turanct\WebHooks\WebHookId;
use Turanct\WebHooks\WebHookWasNotSent;

final class DummyController
{
    private $webhooks;

    public function __construct(WebHooks $webhooks)
    {
        $this->webhooks = $webhooks;
    }

    /**
     * @route /send-webhook
     */
    public function sendWebhook()
    {
        $webhook = new WebHook(
            WebHookId::generate(),
            'https://example.com/webhooks',
            'verification string',
            array('foo' => 'bar', 'baz' => 'qux')
        );

        try {
            $this->webhooks->send($webhook);
        } catch (WebHookWasNotSent $e) {
            return new Response('something went wrong', 500);
        }

        return new Response('webhook was sent', 200);
    }
}
```

Now, every time we visit the url `/send-webhook` on our application, a webhook will be triggered to `https://example.com/webhooks` with the payload we specified above. When something goes wrong, a `WebHookWasNotSent` exception will be thrown, which we can `catch`, as seen in the example above.


## Which implementation to use?

At the time of writing, the recommended implementation of the `WebHooks` interface is the `WebHooksGeneric` class. You can instantiate it like this in your Dependency Injection Container:

```php
$app['webhooks_service'] = function () {
    $httpclient = ... ; // you can implement the `Turanct\WebHooks\HttpClient`
                        // interface yourself, there is no implementation
                        // supplied with this package. You can use the HTTP
                        // client that you're already using in your app by
                        // writing a small implementation of the interface.

    $formatter = new FormatterJSON();
    $signer = new SignerSHA256();

    $webhooks = new WebHooksGeneric(
        $httpclient,
        $formatter,
        $signer
    );

    return $webhooks;
};
```

Now the webhooks service is registered as such in the Dependency Injection container (Pimple in the example).


## Why the `HttpClient` interface and how to use it?

We chose not to ship a default HTTP client implementation with this package to be able to use it with all existing HTTP client packages. We just provided a very small interface that you can easily implement for the HTTP client of your choice. You could then package that implementation in a separate package, and put this package in the composer require statements of your package. That way, dependencies resolve in the right direction (concrete depends on abstract).

Your implementation of the interface should make sure that

- it has an `execute()` method which takes a `HttpRequest` and returns a `HttpResponse`
- it catches all exceptions from the underlying Http client and wraps them in a `HttpClientException` if something fails that we can't recover from.


## What about Retries & Async implementations?

They are in the making. Issues have been created in this repo for that.
