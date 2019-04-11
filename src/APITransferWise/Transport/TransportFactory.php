<?php

namespace APITransferWise\Transport;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\UriTemplate;

abstract class TransportFactory
{
    public static function createGuzzleTransport($opts): GuzzleTransport
    {

        $clientOpts = [
            'base_uri' => $opts['base_url'],

            RequestOptions::TIMEOUT =>
                $opts['timeout'] ?? 30,

            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $opts['token']
            ],
        ];

        $client = new Client($clientOpts);
        return new GuzzleTransport($client, new UriTemplate());
    }
}