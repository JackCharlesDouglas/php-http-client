<?php

namespace Http\Client;

use Exception;
use LogicException;

/**
 * Represents an HTTP response.
 * 
 * @package Http\Client
 * 
 * @author Jack Douglas
 * 
 * @var array $_headers The response headers
 * @var array $_body    The response body
 */
class Response
{
    private array $_headers;
    private array $_body;

    /**
     * Initializes a new instance of the Response class.
     *
     * @throws LogicException If the response cannot be created for any reason.
     */
    public function __construct() 
    {
    }

    /**
     * Gets the response headers as an array
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    
    /**
     * Gets the response body as an array
     *
     * @return array
     */
    public function getBody(): array
    {
        return $this->_body;
    }


    /**
     * Creates a Response object from the given HTTP response headers and body.
     * 
     * @param array  $headers The HTTP response headers
     * @param string $body    The HTTP response body
     * 
     * @return Response The Response object
     *
     * @throws LogicException If the header cannot be processed
     * @throws Exception If the response body is not a valid JSON
     */
    public static function buildResponseFromRequest(array $headers, string $body): Response
    {
        $response = new Response();
        
        try {
            // Deal with the code eg. HTTP/1.1 200 OK
            $responseHeader = array_shift($headers);
            $response->_headers[0] = $responseHeader;

            foreach ($headers as $header) {
                [$key, $value] = explode(':', $header, 2);
                $response->_headers[$key] = trim($value);
            }
        } catch (Exception $e) {
            throw new LogicException('buildResponseFromRequest: Current logic cannot process headers');
        }
        
        try {
            $decodedBody = json_decode($body, true);
            if ($decodedBody === null) {
                throw new Exception('Invalid JSON body');
            }
            $response->_body = $decodedBody; 
        } catch (Exception $e) {
            throw new Exception('buildResponseFromRequest: ' . $e->getMessage());
        }

        return $response;
    }
}
