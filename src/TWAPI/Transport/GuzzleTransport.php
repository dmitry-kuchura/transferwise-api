<?php
/**
 * Created by PhpStorm.
 * User: Hertz
 * Date: 19.11.2018
 * Time: 01:56
 */

namespace TWAPI\Transport;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\UriTemplate;
use Psr\Http\Message\ResponseInterface;

class GuzzleTransport extends Transport
{
    protected $http;
    protected $uriTemplate;

    public function __construct(ClientInterface $http, UriTemplate $uriTemplate)
    {
        $this->http = $http;
        $this->uriTemplate = $uriTemplate;
    }

    protected function httpRequest($method, $uri, $params, $body)
    {
        [$url, $options] = $this->prepareArguments($uri, $params, $body);
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->decode($this->http->request($method, $url, $options));
    }

    protected function decode(ResponseInterface $request)
    {
        return json_decode(
            $request->getBody(),
            true
        );
    }

    /**
     * @param $uri
     * @param $params
     * @return null|string|string[]
     */
    protected function expandUrlTemplate($uri, $params)
    {
        if ($uri && $params) {
            $url = $this->uriTemplate->expand($uri, $params);
        } else {
            $url = $uri;
        }
        return $url;
    }

    /**
     * @param $uri
     * @param $params
     * @param $body
     * @return array
     */
    protected function prepareArguments($uri, $params, $body): array
    {
        $url = $this->expandUrlTemplate($uri, $params);

        $options = [];
        $options[RequestOptions::JSON] = true;
        if ($body !== null) {
            $options[RequestOptions::BODY] = $body;
        }

        return [$url, $options];
    }
}