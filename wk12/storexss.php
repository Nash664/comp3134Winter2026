<?php
/**
 * Intentionally vulnerable: reads stored content and outputs it without encoding.
 * Do not use on a public server.
 */
header('Content-Type: text/html; charset=UTF-8');

$file = __DIR__ . '/storedxss.txt';
if (!is_readable($file)) {
    http_response_code(500);
    echo 'Cannot read storedxss.txt';
    exit;
}

$contents = file_get_contents($file);
echo $contents;
