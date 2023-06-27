<?php

namespace Amorfx\Qube\Tests\DependencyInjection;

use Amorfx\Qube\DependencyInjection\Container;
use Amorfx\Qube\DependencyInjection\ContainerInterface;
use Amorfx\Qube\DependencyInjection\ServiceLocator;
use Amorfx\Qube\Exceptions\NotFoundException;
use Amorfx\Qube\Tests\Fixtures\SampleService;
use PHPUnit\Framework\TestCase;

class ServiceLocatorTest extends TestCase
{
    public function test_it_returns_service(): void
    {
        $container = new Container();
        $container->set(SampleService::class, fn (ContainerInterface $container) => new SampleService('test'));
        $locator = new ServiceLocator($container);
        self::assertInstanceOf(SampleService::class, $locator->get(SampleService::class));
        self::assertSame('test', $locator->get(SampleService::class)->sampleStringProperty);
    }

    public function test_it_throw_exception_not_found_service(): void
    {
        self::expectException(NotFoundException::class);
        $container = new Container();
        $locator = new ServiceLocator($container);
        $locator->get(SampleService::class);
    }
}
