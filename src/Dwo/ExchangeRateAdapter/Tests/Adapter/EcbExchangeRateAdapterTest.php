<?php

namespace Dwo\ExchangeRateAdapter\Tests\Adapter;

use Dwo\Client\Response;
use Dwo\ExchangeRateAdapter\Adapter\EcbExchangeRateAdapter;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class EcbExchangeRateAdapterTest extends \PHPUnit_Framework_TestCase
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
            ->willReturn(new Response(200, '<gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
<gesmes:subject>Reference rates</gesmes:subject>
<gesmes:Sender>
<gesmes:name>European Central Bank</gesmes:name>
</gesmes:Sender>
<Cube>
<Cube time="2016-09-30">
<Cube currency="USD" rate="1.1161"/>
<Cube currency="CHF" rate="0.86103"/>
</Cube>
</Cube>
</gesmes:Envelope>'));

        $adapter = new EcbExchangeRateAdapter($this->client);
        $rates = $adapter->getAll();

        self::assertInternalType('array', $rates);
        self::assertNotEmpty($rates);
        self::assertGreaterThan(1, count($rates));

        self::assertEquals(1, $rates['EUR']);
        self::assertEquals(1.11, $rates['USD'], null, 0.01);
        self::assertEquals(0.86, $rates['CHF'], null, 0.01);
    }
}
