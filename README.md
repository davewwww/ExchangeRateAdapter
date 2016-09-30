[![Build Status](https://travis-ci.org/davewwww/ExchangeRateAdapter.svg?branch=v1.0.1)](https://travis-ci.org/davewwww/ExchangeRateAdapter) [![Coverage Status](https://coveralls.io/repos/davewwww/ExchangeRateAdapter/badge.svg)](https://coveralls.io/r/davewwww/ExchangeRateAdapter)

ExchangeRateAdapter
===================

Grep the Euro foreign exchange reference rates from the ECB or openexchangerates.org

- https://www.ecb.europa.eu/stats/exchange/eurofxref/html/index.en.html
- http://openexchangerates.org/

### Installation

Installation with Composer

```yml
composer require dwo/exchange_rate_adapter
```

### Usage with ECB

```php 
$adapter = new EcbExchangeRateAdapter();
$exchangeRates = $adapter->getAll();
```

### Usage with openexchangerates.org

```php 
$adapter = new OpenExchangeRateAdapter($yourAppId);
$exchangeRates = $adapter->getAll();
```

You will receive an array with the available currencies

```php
   array(31) {
     ["USD"]=>
     float(1.0711)
     ["JPY"]=>
     float(127.64)
     ...
   )
```