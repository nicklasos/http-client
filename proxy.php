<?php

if (($_SERVER['HTTP_PASSWORD'] ?? null) !== 'ProxyPassword') {
    http_response_code(401);
    exit();
}

$response = file_get_contents(urldecode($_GET['url']), false, stream_context_create([
    'http' => [
        'ignore_errors' => true,
        'timeout' => 10,
    ],
]));

foreach ($http_response_header as $header) {
    if (preg_match('#HTTP/[0-9\.]+\s+([0-9]+)#', $header, $out)) {
        http_response_code($out[1]);
        break;
    }
}

echo $response;
