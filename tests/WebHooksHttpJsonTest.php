<?php

namespace Turanct\WebHooks;

class WebHooksHttpJsonTest extends \PHPUnit_Framework_TestCase
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

        $webhooks = new WebHooksHttpJson($client);
        $webhooks->send(new WebHook('foo', 'bar', array('baz', 'qux')));
    }

    public function test_it_sends_an_http_request()
    {
        $expectedRequest = new HttpRequest(
            'POST',
            'http://foo.com/webhooks',
            array(),
            array(
                'User-Agent' => 'Turanct/WebHooks',
                'Content-Type' => 'application/json',
                'Content-Length' => 13,
                'X-Signature' => '46c22b6d7ce8492f68feeb9ade0908dac15bd07f',
            ),
            '["baz","qux"]'
        );

        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expectedRequest));

        $webhooks = new WebHooksHttpJson($client);
        $webhooks->send(
            new WebHook('http://foo.com/webhooks', 'bar', array('baz', 'qux'))
        );
    }
}
