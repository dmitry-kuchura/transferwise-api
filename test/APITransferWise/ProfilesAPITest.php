<?php

namespace test\APITransferWise;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use APITransferWise\ProfilesAPI;
use APITransferWise\Transport\Transport;

class ProfilesAPITest extends TestCase
{

    protected function construct(): array
    {
        $transport = $this->createTransportMock();

        return [
            $transport,
            new ProfilesAPI($transport)
        ];
    }

    public function testListWithoutFilters(): void
    {
        [$transport, $instance] = $this->construct();

        /** @var MockObject $transport */
        $transport->expects($this->once())
            ->method('get')
            ->with(
                '/transfers/{?offset,limit,profile,status,createdDateStart,createdDateEnd}',
                []
            )
            ->willReturn(new Response(200, [], '{"sample":"response"}'));

        /** @var ProfilesAPI $transport */
        $res = $instance->list();
        $this->assertEquals([
            'sample' => 'response'
        ], $res);
    }

    public function testListWithFilters(): void
    {
        [$transport, $instance] = $this->construct();

        /** @var MockObject $transport */
        $transport->expects($this->once())
            ->method('get')
            ->with(
                '/transfers/{?offset,limit,profile,status,createdDateStart,createdDateEnd}',
                ['offset' => 100]
            )
            ->willReturn(new Response(200, [], '{"sample":"response"}'));

        /** @var ProfilesAPI $transport */
        $res = $instance->list(['offset' => 100]);
        $this->assertEquals([
            'sample' => 'response'
        ], $res);
    }
}
