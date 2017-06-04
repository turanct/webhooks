<?php

namespace Turanct\WebHooks;

class HttpClientUserAgentTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_adds_a_user_agent_if_none_exist()
    {
        $expected = new HttpRequest(
            'POST',
            'http://foo.bar',
            array(),
            array(
                'User-Agent' => 'foo',
            )
        );

        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expected));

        $contentLength = new HttpClientUserAgent($client, 'foo');

        $contentLength->execute(
            new HttpRequest(
                'POST',
                'http://foo.bar'
            )
        );
    }

    public function test_it_overwrites_the_user_agent_if_one_exist()
    {
        $expected = new HttpRequest(
            'POST',
            'http://foo.bar',
            array(),
            array(
                'User-Agent' => 'foo',
                'Content-Length' => 0,
            )
        );

        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expected));

        $contentLength = new HttpClientUserAgent($client, 'foo');

        $contentLength->execute(
            new HttpRequest(
                'POST',
                'http://foo.bar',
                array(),
                array(
                    'User-Agent' => 'bar',
                    'Content-Length' => 0,
                )
            )
        );
    }
}
