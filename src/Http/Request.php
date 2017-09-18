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
    public function post(string $url, array $headers = [], string $data = '', array $params = []): Response
    {
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => $this->headers($headers),
                'content' => $data,
            ],
        ];

        return $this->request($url, $opts, $params);
    }

    public function put(string $url, array $headers = [], string $data = '', array $params = []): Response
    {
        $opts = [
            'http' => [
                'method' => 'PUT',
                'header' => $this->headers($headers),
                'content' => $data,
            ],
        ];

        return $this->request($url, $opts, $params);
    }

    public function get(string $url, array $headers = [], array $params = []): Response
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => $this->headers($headers),
            ],
        ];

        return $this->request($url, $opts, $params);
    }
    
    public function proxyGet(string $url, array $headers = [], array $params = []): Response
    {
        $proxy = array_random(config('proxy'));

        $headers['Password'] = 'ProxyPassword';

        return $this->get("$proxy?url=$url", $headers, $params);
    }

    private function headers(array $headers): string
    {
        $result = '';
        foreach ($headers as $key => $val) {
            $result .= $key . ': ' . $val . PHP_EOL;
        }

        return $result;
    }

    private function request(string $url, array $opts, array $params): Response
    {
        $opts = array_merge_recursive($opts, $params);

        $opts['http']['ignore_errors'] = $opts['http']['ignore_errors'] ?? true;
        $opts['http']['timeout'] = $opts['http']['timeout'] ?? 10;

        $content = file_get_contents($url, false, stream_context_create($opts));

        return new Response($content, $http_response_header);
    }
