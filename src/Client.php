<?php

namespace Http\Client;

require __DIR__ . '\Response.php';

use Exception;
use Http\Client\Request;

/**
 * Represents an HTTP client.
 * 
 * @package Http\Client
 * 
 * @author Jack Douglas
 * 
 * @var string DEFAULT_USER_AGENT The default user agent
 * @var string DEFAULT_ACCEPT    The default Accept header
 * @var string DEFAULT_CONNECTION The default Connection header
 */
class Client
{
    private const DEFAULT_USER_AGENT = 'jackcharlesdouglas/php-http-client';
    private const DEFAULT_ACCEPT = 'Accept: application/json';
    private const DEFAULT_CONNECTION = 'Connection: Close';

    /**
     * Initializes a new instance of the Client class.
     */
    public function __construct()
    {    
    }

    /**
     * Sends the given request using the given stream context.
     *
     * @param Request  $request The request to send
     * @param resource $context The stream context to use for the request
     *
     * @return array The request headers and body as an array
     *
     * @throws Exception If the request cannot be sent for any reason
     */
    private function _handleRequest(Request $request, $context): array
    {
        $body = file_get_contents($request->getUrl(), false, $context);

        if ($body === false) {
            $socketErr = socket_last_error();
            throw new Exception('handleRequest: ' . socket_strerror($socketErr));
        }

        return [$http_response_header, $body];
    }

    /**
     * Creates a stream context option array from the given request.
     *
     * @param Request $request The request to create a stream context for
     *
     * @return resource The stream context options
     *
     * @throws Exception If the request body is not a valid JSON
     */
    private function _createContext(Request $request)
    {
        $method = $request->getMethod();
        $headers = $request->getHeaders();

        $options = [
            'http' => [
                'method' => $method,
                'user_agent' => self::DEFAULT_USER_AGENT,
                'header' => [self::DEFAULT_ACCEPT, self::DEFAULT_CONNECTION, ...$headers],
            ]
        ];

        if ($method === Request::METHOD_POST) {
            $encodedBody = json_encode($request->getBody());
            if ($encodedBody === false) {
                throw new Exception('createContext: Invalid JSON body');
            }
            $options['http']['content'] = $encodedBody;
            $options['http']['header'][] = 'Content-Type:application/json';
        }

        return stream_context_create($options);
    }

    /**
     * Sends the given request and returns the response.
     * 
     * @param Request $request The request to send
     * 
     * @return Response The response from the server
     * 
     * @throws Exception If the request cannot be sent for any reason
     */
    public function sendRequest(Request $request): Response
    {
        $context = $this->_createContext($request);
        [$headers, $body] = $this->_handleRequest($request, $context);
        return Response::buildResponseFromRequest($headers, $body);
    }
}
