<?php
namespace Http;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    const SERVER = 'http://localhost:3838/server.php';

    public function testGet()
    {
        $client = new Request();

        $response = $client->get(self::SERVER);

        $this->assertEquals('{"foo": "bar"}', $response->content());

        $this->assertEquals('test-content', $response->headers()['Test-Header']);

        $this->assertEquals(['foo' => 'bar'], $response->json());
    }
}
