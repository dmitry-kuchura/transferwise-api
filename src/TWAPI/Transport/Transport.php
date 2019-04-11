<?php
declare(strict_types=1);

namespace TWAPI\Transport;

abstract class Transport
{
    protected const METHOD_GET = 'GET';
    protected const METHOD_POST = 'POST';
    protected const METHOD_PUT = 'PUT';
    protected const METHOD_DELETE = 'DELETE';

    abstract protected function httpRequest($method, $uri, $params, $body);

    public function request($method, $uri, $params = [], $body = null)
    {
        return $this->httpRequest($method, $uri, $params, $body);
    }


    public function get($uri, $params = [])
    {
        return $this->request(self::METHOD_GET, $uri, $params, null);
    }


    public function post($uri, $params = [], $body = null)
    {
        return $this->request(self::METHOD_POST, $uri, $params, $body);
    }


    public function put($uri, $params = [], $body = null)
    {
        return $this->request(self::METHOD_PUT, $uri, $params, $body);
    }


    public function delete($uri, $params = [], $body = null)
    {
        return $this->request(self::METHOD_DELETE, $uri, $params, $body);
    }

}