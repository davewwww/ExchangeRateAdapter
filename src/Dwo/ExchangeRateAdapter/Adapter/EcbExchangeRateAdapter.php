<?php

namespace Dwo\ExchangeRateAdapter\Adapter;

use Dwo\Client\Clients\ClientInterface;
use Dwo\Client\Clients\GuzzleClient;

/**
 * Class EcbExchangeRateAdapter
 *
 * @see    https://www.ecb.europa.eu/stats/exchange/eurofxref/html/index.en.html
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class EcbExchangeRateAdapter implements ExchangeRateAdapterInterface
{
    const URL = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

    /**
     * @var ClientInterface
     */
    public $client;

    /**
     * OpenExchangeRateAdapter constructor.
     *
     * @param ClientInterface|null $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new GuzzleClient();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $currencies = array();

        $response = $this->client->get(self::URL);

        $xml = simplexml_load_string($response->getContent());
        foreach ($xml->Cube->Cube->Cube as $rate) {
            $currencies[(string) $rate['currency']] = (float) $rate['rate'];
        }

        $currencies['EUR'] = 1;

        return $currencies;
    }
}