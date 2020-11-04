# Mati library for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wedevbr/mati-laravel.svg?style=flat-square)](https://packagist.org/packages/wedevbr/mati-laravel)
[![Build Status](https://img.shields.io/travis/wedevbr/mati-laravel/master.svg?style=flat-square)](https://travis-ci.org/wedevbr/mati-laravel)
[![Quality Score](https://img.shields.io/scrutinizer/g/wedevbr/mati-laravel.svg?style=flat-square)](https://scrutinizer-ci.com/g/wedevbr/mati-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/wedevbr/mati-laravel.svg?style=flat-square)](https://packagist.org/packages/wedevbr/mati-laravel)



## Installation

You can install the package via composer:

```bash
composer require wedevbr/mati-laravel
```
After installed publish the config file:
```bash
php artisan vendor:publish --provider="WeDevBr\Mati\MatiServiceProvider"
```

## Usage
Mati class can be accessed via facade, singleton or IoC container
```php
// Using facade
use WeDevBr\Mati\MatiFacade;
$result = MatiFacade::createVerification();

// Using singleton
$result = $this->mati->createVerification();

// Using IoC container
use WeDevBr\Mati\Mati;
# ...
public function myFunction(Mati $mati) {
    $result = $mati->createVerification();
    # ...
}
```
A complete process looks like this:
```php
$verification = MatiFacade::createVerification(['id' => 'localUserId'], 'flowId', '10.20.30.40', 'User-Agent String');

$document1 = new \WeDevBr\Mati\Inputs\DocumentPhoto;
$document1->setGroup(0)
    ->setType('national-id')
    ->setCountry('US')
    ->setRegion('CA')
    ->setPage('front')
    ->setFilePath('/tmp/doc001.jpg');

Mati::sendInputs($verification->identity, [$document1]);

// After the webhook notification, data can be acquired doing this:
$status = MatiFacade::retrieveResourceDataFromUrl($webhook_data->resource);
```
### Configuration
The recommended way to configure is to set the environment variables `MATI_CLIENT_ID` and `MATI_CLIENT_SECRET`. This way no further step is required to authorize for the verification. Additionally, `MATI_AUTH_URL` and `MATI_API_URL` can be set for test purposes.
If you don't want to use the environment to config, client ID and secret can be passed to the constructor of `Mati` class instead, and the constructor will deal with authorization.
If you already have a valid access token, you can instantiate `Mati` without build parameters and call the method `setAccessToken`

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email contato@wedev.software instead of using the issue tracker.

## Credits

- [We Dev Tecnologia](https://github.com/wedevbr)
- [Gabriel Mineiro](https://github.com/Mineirovsky)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
