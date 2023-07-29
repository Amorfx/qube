# Qube

[![Latest Version on Packagist](https://img.shields.io/packagist/v/clementdecou/qube.svg?style=flat-square)](https://packagist.org/packages/clementdecou/qube)
[![Tests](https://img.shields.io/github/actions/workflow/status/amorfx/qube/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/amorfx/qube/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/clementdecou/qube.svg?style=flat-square)](https://packagist.org/packages/qube/qube-php)

Qube is a lightweight and simple dependency injection container.

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

## Defining Services
Register a service with a unique identifier so that it can be retrieved later. Services can be objects or closures.
    
```php
$container->set('my_service', new MyService());
```
### Defining Services with a factory
If a service has multiple dependencies you can define a factory for your service.
    
```php
use Amorfx\Qube\DependencyInjection\ContainerInterface;

$container->set('my_service', function (ContainerInterface $container) {
    return new MyService($container->get('service1'), $container->get('service2'));
});
```
Notice that the anonymous function has access to the current container instance, allowing references to other services or parameters.
As objects are only created when you get them, the order of the definitions does not matter.

### Defining Services not shareable
By default, each time you get a service, the same instance is returned. If you want a different instance to be returned for all calls, use the share parameter.

```php
$container->set('my_service', new MyService(), false);
```
Now, each call to 'my_service' returns a new instance of the service.

### Defining Services with a tag
You can tag a service with a specific tag. This is useful when you want to retrieve multiple services with the same tag.

```php
$container->set('my_service', new MyService(), tags: ['tag1', 'tag2']);
```

## Retrieve a service
Retrieve a previously registered service using its identifier.

```php
$service = $container->get('my_service');
```

### Retrieve multiple services with tags
It will return a generator with all services tagged. You can iterate over it or use the `iterator_to_array` function to get an array.
```php
$services = $container->getByTag('tag1');
```

## Defining Parameters
Defining a parameter allows to ease the configuration of your container from the outside and to store global values:
    
```php
$container->setParameter('my_param', 'my_value');
```
## Retrieve a parameter
Retrieve a previously registered parameter using its identifier.

```php
$param = $container->getParameter('my_param'); // return my_value
```

## Extending a Container
If you use the same libraries over and over, you might want to reuse some services from one project to the next one.
Package your services into a provider by implementing Qube\DependencyInjection\ServiceProviderInterface:
    
```php
use Amorfx\Qube\DependencyInjection\ServiceProviderInterface;
use Amorfx\Qube\DependencyInjection\Container;
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        // register services and parameters or other providers
    }
}
```
Then register your provider into the container:
```php
$container->registerProviders([new ServiceProvider()]);
// OR
$container->registerProvider(new ServiceProvider());
```

## Using the builder / or configuration file
You can use the builder to create your container. It will allow you to use a configuration file to define your services and parameters.
```php
use Amorfx\Qube\DependencyInjection\ContainerBuilder;
use Amorfx\Qube\quBuilder;

$builder = new ContainerBuilder(configFilePath: __DIR__ . '/config.php');
$container = $builder->get();

// OR use helper function
$container = quBuilder()
->fromConfig(__DIR__ . '/config.php')
->get();

// Or directly from an array
$container = (new ContainerBuilder(config: [...]))->get();
```
The configuration file must return an array with the following structure:
```php
return [
    'parameters' => [
        //list of parameter identifier with their value
        'param1' => 'value1',
        // ...
    ],
    
    'services' => [ // list of you services
    
        'service1' => [ // the service identifier
            'object' => // an instance of your service or use factory
            'factory' => function (ContainerInterface $container) {
                // the closure to return your service instance
            },
            'tags' => [], // a list of tags
            'share' => false, // if the service is shareable, default is true
        ],
        // ...
    ],
    
    'providers' => [
        // the list of your providers class name
    ],
];
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

- [Clément Décou](https://github.com/amorfx)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
