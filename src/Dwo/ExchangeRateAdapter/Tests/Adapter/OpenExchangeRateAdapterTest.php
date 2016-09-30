<?php

namespace Dwo\ExchangeRateAdapter\Tests\Adapter;

use Dwo\Client\Response;
use Dwo\ExchangeRateAdapter\Adapter\OpenExchangeRateAdapter;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class OpenExchangeRateAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Dwo\Client\Clients\ClientInterface
     */
    protected $client;

    public function setup()
    {
        $this->client = $this->getMockBuilder('\Dwo\Client\Clients\ClientInterface')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetAll()
    {
        $this->client->expects(self::once())
            ->method('get')
            ->willReturn(new Response(200, json_encode(
                array('rates' => array('EUR' => 0.88, 'USD' => 1, 'CHF' => 0.96))
            )));

        $adapter = new OpenExchangeRateAdapter('foo', $this->client);
        $rates = $adapter->getAll();

        self::assertInternalType('array', $rates);
        self::assertNotEmpty($rates);
        self::assertGreaterThan(1, count($rates));

        self::assertEquals(1, $rates['EUR']);
        self::assertEquals(1.13, $rates['USD'], null, 0.01);
        self::assertEquals(1.09, $rates['CHF'], null, 0.01);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetAllException()
    {
        $this->client->expects(self::once())
            ->method('get')
            ->willReturn(new Response(200, 'foo'));

        $adapter = new OpenExchangeRateAdapter('foo', $this->client);
        $adapter->getAll();
    }
}
