<?php

namespace Turanct\WebHooks;

class HttpClientContentLengthTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_adds_a_content_length_header_of_0()
    {
        $expected = new HttpRequest(
            'POST',
            'http://foo.bar',
            array(),
            array(
                'Content-Length' => '0',
            )
        );

        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expected));

        $contentLength = new HttpClientContentLength($client);

        $contentLength->execute(
            new HttpRequest(
                'POST',
                'http://foo.bar'
            )
        );
    }

    public function test_it_adds_a_content_length_header_of_x()
    {
        $expected = new HttpRequest(
            'POST',
            'http://foo.bar',
            array(),
            array(
                'Content-Length' => '37',
            ),
            '{"foo": "bar", "baz": ["qux", "qux"]}'
        );

        $client = $this->getMock('Turanct\\WebHooks\\HttpClient');
        $client
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expected));

        $contentLength = new HttpClientContentLength($client);

        $contentLength->execute(
            new HttpRequest(
                'POST',
                'http://foo.bar',
                array(),
                array(),
                '{"foo": "bar", "baz": ["qux", "qux"]}'
            )
        );
    }
}
