# pappers.fr API for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/finller/laravel-pappers.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-pappers)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-pappers/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/finller/laravel-pappers/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/finller/laravel-pappers/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/finller/laravel-pappers/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/finller/laravel-pappers.svg?style=flat-square)](https://packagist.org/packages/finller/laravel-pappers)

Easily use pappers.fr Entreprises API within Laravel.

Based on Saloon and supporting cache and rate limiting.

## Installation

You can install the package via composer:

```bash
composer require finller/laravel-pappers
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="pappers-config"
```

This is the contents of the published config file:

```php
return [

    'france' => [
        'token' => env('PAPPERS_FRANCE_TOKEN'),
        'version' => env('PAPPERS_FRANCE_VERSION'),
    ],

    'international' => [
        'token' => env('PAPPERS_INTERNATIONAL_TOKEN'),
        'version' => env('PAPPERS_INTERNATIONAL_VERSION'),
    ],

    'cache' => [
        'enabled' => true,
        'driver' => env('PAPPERS_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
        'expiry_seconds' => 604_800, // 1 week
    ],

    'rate_limit' => [
        'enabled' => false,
        'driver' => env('PAPPERS_RATE_LIMIT_DRIVER', env('CACHE_DRIVER', 'file')),
        'every_minute' => 30,
    ],
];
```

## Usage

```php
use Elegantly\Pappers\Facades\Pappers;
use Elegantly\Pappers\Integrations\France\Requests\EntrepriseRequest;

$entreprise = Pappers::france()->send(new EntrepriseRequest(
    siren: "897962361"
));
```

```php
use Elegantly\Pappers\Facades\Pappers;
use Elegantly\Pappers\Integrations\International\Requests\CompanyRequest;

$entreprise = Pappers::international()->send(new CompanyRequest(
    country_code: "FR",
    company_number: "897962361"
));
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Quentin Gabriele](https://github.com/40128136+QuentinGab)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
