<?php

namespace Http\Client;

require __DIR__ . '\Request.php';
require __DIR__ . '\Client.php';

use Http\Client\Client;
use Http\Client\Request;

$client = new Client();

$request = new Request(Request::METHOD_GET, 'https://official-joke-api.appspot.com/random_joke', [], []);
$response = $client->sendRequest($request);
print_r($response->getBody());
echo PHP_EOL;

$request = new Request(Request::METHOD_POST, 'https://httpbin.org/post', [], ['I' => 'am', 'a' => 'developer']);
$response = $client->sendRequest($request);
print_r($response->getBody());
echo PHP_EOL;

// TODO: Add more tests