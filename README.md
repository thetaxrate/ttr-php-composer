#  TheTaxRate API 
The purpose of this package is to make integration with [thetaxrate](home-url) sales tax api multi easier with composer.

## Installation

Via Composer

``` bash
$ composer require thetaxrate/ttr-php-composer
```

## Usage

Latest Documentation Can be found at [Site Documentation](https://thetaxrate.com/docs/1.0/php-composer/php-overview)

You will need to Obtain an API token from thetaxrate.com users portal.

```php
<?php

namespace {
    use TheTaxRate\SalesTaxService;

    function main() {
        $service = new SalesTaxService('API_TOKEN');
        $response = $service->getTaxRate('90210');
        $saleTaxRate = $response->getRate();
    }
}
```

## Security
If you discover any security related issues, please submit a PR.




## License

license. Please see the [license file](license.md) for more information.


[home-url]: https://thetaxrate.com
