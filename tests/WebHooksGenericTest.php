<?php

namespace Turanct\WebHooks;

class WebHooksGenericTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Turanct\WebHooks\WebHookWasNotSent
     */
    public function test_it_throws_when_connection_fails()
    {
        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->method('execute')
            ->will($this->throwException(new WebHookWasNotSent()));

        $formatter = $this->getMock('Turanct\\WebHooks\\Formatter');
        $formatter
            ->method('format')
            ->willReturn('foo');

        $signer = $this->getMock('Turanct\\WebHooks\\Signer');
        $signer
            ->method('sign')
            ->willReturn('bar');

        $webhooks = new WebHooksGeneric($client, $formatter, $signer);
        $webhooks->send(
            new WebHook(WebHookId::generate(), 'foo', 'bar', array('baz', 'qux'))
        );
    }

    public function test_it_sends_an_http_request()
    {
        $webhookId = WebHookId::generate();

        $expectedRequest = new HttpRequest(
            'POST',
            'http://foo.com/webhooks',
            array(),
            array(
                'Content-Type' => 'application/json',
                'X-Signature' => 'bar',
                'X-Id' => (string) $webhookId,
            ),
            'foo'
        );

        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expectedRequest));

        $formatter = $this->getMock('Turanct\\WebHooks\\Formatter');
        $formatter
            ->method('format')
            ->willReturn('foo');
        $formatter
            ->method('getContentType')
            ->willReturn('application/json');

        $signer = $this->getMock('Turanct\\WebHooks\\Signer');
        $signer
            ->method('sign')
            ->willReturn('bar');

        $webhooks = new WebHooksGeneric($client, $formatter, $signer);
        $webhooks->send(
            new WebHook(
                $webhookId,
                'http://foo.com/webhooks',
                'bar',
                array('baz', 'qux')
            )
        );
    }
}
