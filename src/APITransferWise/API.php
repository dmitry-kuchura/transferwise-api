<?php

namespace APITransferWise;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\UriTemplate;
use TWAPI\Transport\GuzzleTransport;
use TWAPI\Transport\Transport;
use TWAPI\Transport\TransportFactory;

class API
{
    const BASE_URL_API_PRODUCTION = 'https://api.transferwise.tech/v1/';

    const BASE_URL_API_SANDBOX = 'https://api.sandbox.transferwise.tech/v1/';

    protected $profiles;

    protected $apiToken;
    /**
     * @var Transport
     */
    protected $transport;

    /**
     * API constructor.
     * @param $token access token
     * @param array $options Advanced options for transport
     */
    public function __construct($token, array $options = [])
    {
        $this->transport = $this->buildTransport($token, $options);
    }

    protected function getBaseUri($opts): string
    {
        return isset($opts['sandbox']) && $opts['sandbox']
            ? self::BASE_URL_API_SANDBOX
            : self::BASE_URL_API_PRODUCTION;
    }

    protected function buildTransport($token, $options)
    {
        $baseUrl = $this->getBaseUri($options);

        $opts = array_merge([], $options);
        $opts['base_url'] = $baseUrl;
        $opts['token'] = $token;

        return TransportFactory::createGuzzleTransport($opts);
    }


    public function profiles()
    {
        if (!$this->profiles) {
            $this->profiles = new ProfilesAPI($this->transport);
        }
        return $this->profiles;
    }


}