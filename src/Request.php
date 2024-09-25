<?php

namespace Http\Client;

class Request
{
    private string $_method;
    private string $_url;
    private array $_headers;
    private array $_body;
    private bool $_secure;

    public function __construct(string $method, string $url, array $headers = [], array $body = [])
    {
        $this->_method = $method;
        $this->_url = $url;
        $this->_headers = $headers;
        $this->_body = $body;

        // Host is secure if starts with https:// or doesn't start with https:// http://
        $this->_secure = strpos($url, 'https://') === 0 || strpos($url, 'http://') !== 0;
    }

    public function getMethod(): string
    {
        return $this->_method;
    }

    public function getUrl(): string
    {
        return $this->_url;
    }

    public function getHeaders(): array
    {
        return $this->_headers;
    }

    public function getBody(): array
    {
        return $this->_body;
    }

    public function getSecure(): bool
    {
        return $this->_secure;
    }
}
