<?php
namespace Http;

/**
 * <code>
 * $client = new \Http\Client();
 *
 * $response = $client->get('http://google.com');
 *
 * $response->content(); // text response
 * $response->headers(); // array
 * $response->status(); // 200, etc…
 * $response->json(); // equals to json_decode($response->content(), true);
 *
 * // GET with headers:
 *
 * $client->get('http://foo', ['Content-Type' => 'application/json']);
 *
 * // POST
 *
 * $headers = ['Content-Type' => 'application/json’];
 * $body = json_encode([‘foo’ => ‘bar’]);
 *
 * $client->post('http://foo', $headers, $body);
 * </code>
 */
class Request
{
    public function post(string $url, array $headers = [], string $data = ''): Response
    {
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => $this->headers($headers),
                'content' => $data,
            ],
        ];

        return $this->request($url, $opts);
    }

    public function get(string $url, array $headers = []): Response
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => $this->headers($headers),
            ],
        ];

        return $this->request($url, $opts);
    }

    private function request(string $url, array $opts): Response
    {
        $content = file_get_contents($url, false, stream_context_create($opts));

        return new Response($content, $http_response_header);
    }

    private function headers(array $headers): string
    {
        $result = '';
        foreach ($headers as $key => $val) {
            $result .= $key . ': ' . $val . PHP_EOL;
        }

        return $result;
    }
}
