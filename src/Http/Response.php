<?php
namespace Http;

class Response
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $headers;

    public function __construct(string $content, array $headers = [])
    {
        $this->content = $content;
        $this->headers = $this->parseHeaders($headers);
    }

    public function content(): string
    {
        return $this->content;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function json(): array
    {
        return json_decode($this->content, true);
    }

    private function parseHeaders(array $headers): array
    {
        $head = [];

        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match('#HTTP/[0-9\.]+\s+([0-9]+)#', $v, $out)) {
                    $head['response_code'] = intval($out[1]);
                }
            }
        }

        return $head;
    }

    /**
     * @return int|null
     */
    public function status()
    {
        return $this->headers['response_code'] ?? null;
    }
}
