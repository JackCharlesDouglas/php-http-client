<?php

namespace Http\Client;

require __DIR__ . '\Utils.php';

use Exception;
use Http\Client\Utils;

/**
 * Represents an HTTP request.
 * 
 * @package Http\Client
 * 
 * @author Jack Douglas
 * 
 * @var 'GET' |'POST' |'OPTIONS' $method  The request method
 * @var string                   $url     The request URL
 * @var array                    $headers The request headers
 * @var array                    $body    The request body
 */
class Request
{
    use Utils;

    private string $_method;
    private string $_url;
    private array $_headers;
    private array $_body;

    // Not sure if I'm allowed to use PHP 8 enums, let's keep this simple
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_OPTIONS = 'OPTIONS';

    /**
     * Initializes a new instance of the Request class.
     *
     * @param 'GET' |'POST' |'OPTIONS' $method  The request method
     * @param string                   $url     The request URL
     * @param array                    $headers The request headers
     * @param array                    $body    The request body
     */
    public function __construct(string $method, string $url, array $headers, array $body)
    {
        if (!in_array($method, [self::METHOD_GET, self::METHOD_POST, self::METHOD_OPTIONS])) {
            throw new Exception('Request: Invalid request method');
        }
        $this->_method = $method;

        if (!$this->isAssocArray($headers)) {
            throw new Exception('Request: Request headers must be an associative array');
        }
        $this->_headers = $headers;
        
        if (!$this->isAssocArray($body)) {
            throw new Exception('Request: Request body must be an associative array');
        }
        $this->_body = $body;
        
        $this->_url = $url;
    }

    /**
     * Gets the request method as a string
     *
     * @return string The request method GET, POST, OPTIONS
     */
    public function getMethod(): string
    {
        return $this->_method;
    }

    /**
     * Gets the request URL as a string
     *
     * @return string The request URL
     */
    public function getUrl(): string
    {
        return $this->_url;
    }

    /**
     * Gets the request headers as an array
     *
     * @return array The request headers
     */
    public function getHeaders(): array
    {
        return $this->_headers;
    }

    /**
     * Gets the request body as an array
     *
     * @return array The request body
     */
    public function getBody(): array
    {
        return $this->_body;
    }
}
