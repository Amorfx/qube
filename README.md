# Qube

[![Latest Version on Packagist](https://img.shields.io/packagist/v/clementdecou/qube.svg?style=flat-square)](https://packagist.org/packages/clementdecou/qube)
[![Tests](https://img.shields.io/github/actions/workflow/status/amorfx/qube/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/amorfx/qube/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/clementdecou/qube.svg?style=flat-square)](https://packagist.org/packages/qube/qube-php)

Qube is a lightweight and simple dependency injection container.

## Support us

TODO

## Installation

You can install the package via composer:

```bash
composer require clementdecou/qube
```

## Usage

Creating a container is a matter of creating a Container instance:

```php
use Qube\Container;

$container = new Container();
```

Or use the helper function:

```php
use Amorfx\Qube\qube;

$container = qube();
```
It will return a unique instance of the container even if you call it multiple times.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

TODO

## Security Vulnerabilities

TODO

## Credits

- [Clément Décou](https://github.com/amorfx)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
