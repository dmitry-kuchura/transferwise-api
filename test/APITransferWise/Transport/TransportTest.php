<?php
/**
 * Created by PhpStorm.
 * User: Hertz
 * Date: 18.11.2018
 * Time: 22:51
 */

namespace test\TWAPI\Transport;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use test\TWAPI\TestCase;
use TWAPI\Transport\Transport;

class TransportTest extends TestCase
{


    protected function construct(): array
    {
        [$client, $uriTemplate] = $this->createTransportMocks();

        return [
            $client,
            $uriTemplate,
            new Transport($client, $uriTemplate, null)
        ];
    }

    public function testRequest(): void
    {

        [$client, $tpl, $instance] = $this->construct();
        
        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/url', ['json' => true])
            ->willReturn(new Response(200));

        $tpl->expects($this->never())
            ->method($this->anything());

        $res = $instance->request('GET', '/url', [], null);
    }

    public function testRequestWithParams(): void
    {
        [$client, $tpl, $instance] = $this->construct();

        $tpl->expects($this->once())
            ->method('expand')
            ->with('/url{?param1}', ['param1' => 'param1-value'])
            ->willReturn('/url?param1=param1-value');

        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/url?param1=param1-value', ['json' => true])
            ->willReturn(new Response(200));

        $res = $instance->request('GET', '/url{?param1}', ['param1' => 'param1-value']);

        $this->assertInstanceOf(ResponseInterface::class, $res);
    }

    public function testRequestWithBody()
    {
        [$client, $tpl, $instance] = $this->construct();
        
        $tpl->expects($this->never())
            ->method($this->anything());

        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/url', [
                'json' => true,
                'body' => ['somedata' => 'to-send']
            ])
            ->willReturn(new Response(200));

        $res = $instance->request('GET', '/url', null, ['somedata' => 'to-send']);
    }

    public function testGet()
    {
        [$client, $tpl, $instance] = $this->construct();
        
        $tpl->expects($this->never())
            ->method($this->anything());

        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/url', ['json' => true])
            ->willReturn(new Response(200));

        $res = $instance->get('/url');
    }

    public function testPost()
    {
        [$client, $tpl, $instance] = $this->construct();
        
        $tpl->expects($this->never())
            ->method($this->anything());

        $client->expects($this->once())
            ->method('request')
            ->with('POST', '/url', ['json' => true])
            ->willReturn(new Response(200));

        $res = $instance->post('/url');
    }

    public function testPut()
    {
        [$client, $tpl, $instance] = $this->construct();
        
        $tpl->expects($this->never())
            ->method($this->anything());

        $client->expects($this->once())
            ->method('request')
            ->with('PUT', '/url', ['json' => true])
            ->willReturn(new Response(200));

        $res = $instance->put('/url');
    }

    public function testDelete()
    {
        [$client, $tpl, $instance] = $this->construct();
        
        $tpl->expects($this->never())
            ->method($this->anything());

        $client->expects($this->once())
            ->method('request')
            ->with('DELETE', '/url', ['json' => true])
            ->willReturn(new Response(200));

        $res = $instance->delete('/url');
    }


}
