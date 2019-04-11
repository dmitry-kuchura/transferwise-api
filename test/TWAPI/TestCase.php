<?php
declare(strict_types=1);

namespace test\TWAPI;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\UriTemplate;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use TWAPI\Transport\Transport;

class TestCase extends PHPUnitTestCase
{

    protected function createTransportMocks(): array
    {
        $client = $this->createMock(ClientInterface::class);
        $uriTemplate = $this->createMock(UriTemplate::class);
        return [$client, $uriTemplate];
    }

    protected function createTransportMock()
    {
        return $this->createMock(Transport::class);
    }
}