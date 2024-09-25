<?php

namespace Http\Client;

require __DIR__ . '\Request.php';
require __DIR__ . '\Client.php';

use Http\Client\Client;
use Http\Client\Request;

$request = new Request('GET', 'https://api.agify.io/?name=meelad', [], []);

$client = new Client();
$client->sendRequest($request);
