<?php
namespace Http;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testContent()
    {
        $response = new Response('Test content', []);

        $this->assertEquals('Test content', $response->content());
    }

    public function testHeaders()
    {
        $headers = [
            'HTTP/1.0 302 Found',
            'Cache-Control: private',
            'Content-Type: text/html; charset=UTF-8',
            'Location: http://www.google.com.ua/?gfe_rd=cr&ei=d2QQWOaZG7HG7gTR4JiQBA',
            'Content-Length: 262',
            'Date: Wed, 26 Oct 2016 08:08:23 GMT',
            'HTTP/1.0 200 OK',
            'Date: Wed, 26 Oct 2016 08:08:23 GMT',
            'Expires: -1',
            'Cache-Control: private, max-age=0',
            'Content-Type: text/html; charset=windows-1251',
            'P3P: CP="This is not a P3P policy! See https://www.google.com/support/accounts/answer/151657?hl=en for more info."',
            'Server: gws',
            'X-XSS-Protection: 1; mode=block',
            'X-Frame-Options: SAMEORIGIN',
            'Set-Cookie: NID=89=GYqmjY; expires=Thu, 27-Apr-2017 08:08:23 GMT; path=/; domain=.google.com.ua; HttpOnly',
            'Accept-Ranges: none',
            'Vary: Accept-Encoding',
        ];

        $response = new Response('content', $headers);

        $responseHeaders = $response->headers();

        $this->assertEquals('Wed, 26 Oct 2016 08:08:23 GMT', $responseHeaders['Date']);

        $this->assertEquals('HTTP/1.0 302 Found', $responseHeaders[0]);
        $this->assertEquals('HTTP/1.0 200 OK', $responseHeaders[1]);

        $this->assertEquals(200, $response->status());
    }

    public function testJson()
    {
        $response = new Response('{"foo": "bar"}', []);

        $this->assertEquals(['foo' => 'bar'], $response->json());
    }
}