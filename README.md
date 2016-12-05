# http-client
PHP HTTP client based on file_get_context and streams.

```php
<?php

$client = new \Http\Request();

$response = $client->get('http://google.com');

$response->content(); // text response
$response->headers(); // array
$response->status(); // 200, etc…
$response->json(); // equals to json_decode($response->content(), true);

// GET with headers:

$client->get('http://foo', ['Content-Type' => 'application/json']);

// POST

$headers = ['Content-Type' => 'application/json'];
$body = json_encode(['foo' => 'bar']);

$client->post('http://foo', $headers, $body);
```