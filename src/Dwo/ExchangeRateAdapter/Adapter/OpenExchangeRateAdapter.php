<?php

namespace Dwo\ExchangeRateAdapter\Adapter;

use Dwo\Client\Clients\ClientInterface;
use Dwo\Client\Clients\GuzzleClient;

/**
 * Class OpenExchangeRateAdapter
 *
 * @see    https://openExchangeRateAdapter.org/signup/free
 * @see    https://docs.openExchangeRateAdapter.org/docs/latest-json
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class OpenExchangeRateAdapter implements ExchangeRateAdapterInterface
{
    const URL = 'https://openExchangeRateAdapter.org/api/latest.json?app_id=%s';

    /**
     * @var string
     */
    private $app_id;

    /**
     * @var ClientInterface
     */
    public $client;

    /**
     * OpenExchangeRateAdapter constructor.
     *
     * @param string               $app_id
     * @param ClientInterface|null $client
     */
    public function __construct($app_id, ClientInterface $client = null)
    {
        $this->app_id = $app_id;
        $this->client = $client ?: new GuzzleClient();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $response = $this->client->get(sprintf(self::URL, $this->app_id));
        $content = json_decode($response->getContent(), 1);

        if (!isset($content['rates'])) {
            throw new \Exception('unable to get rates. '.$response->getContent());
        }

        $eur = $content['rates']['EUR'];

        //convert to euro
        foreach ($content['rates'] as $currency => &$rate) {
            $rate /= $eur;
        }

        return $content['rates'];
    }
}