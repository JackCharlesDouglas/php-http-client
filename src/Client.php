<?php

namespace Http\Client;

use Exception;
use Socket;
use Http\Client\Request;

class Client
{
    private const HTTP_PORT = 80;
    private const HTTPS_PORT = 443;
    private const DEFAULT_ACCEPT = 'Accept:application/json';
    private const DEFAULT_CONNECTION = 'Connection:Close';
    
    public function __construct()
    {
    }

    private function createContext(Request $request)
    {
        $headers = $request->getHeaders();
        $options = [
            'http' => [
                'method' => $request->getMethod(),
                'user_agent' => 'JackCharlesDouglas/php-http-client',
                'header' => [self::DEFAULT_ACCEPT, self::DEFAULT_CONNECTION, ...$headers],
            ]
            ];
        return stream_context_create($options);
    }

    public function sendRequest(Request $request)
    {
        $context = $this->createContext($request); 

        $result = file_get_contents($request->getUrl(), false, $context);
        if ($result === false) {
            $socketErr = socket_last_error();
            throw new Exception("file_get_contents() failed: " . socket_strerror($socketErr));
        }

        echo $result;
    }
}
