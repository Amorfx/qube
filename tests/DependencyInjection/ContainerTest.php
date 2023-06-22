<?php

namespace Amorfx\Qube\Tests\DependencyInjection;

use Amorfx\Qube\DependencyInjection\Container;
use Amorfx\Qube\DependencyInjection\ContainerInterface;
use Amorfx\Qube\Exceptions\AlreadySetParameterException;
use Amorfx\Qube\Exceptions\NotFoundException;
use Amorfx\Qube\Tests\Fixtures\SampleService;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    public function test_get_set_parameter_ok(): void
    {
        $this->container->setParameter('my.param', 'isOk');
        self::assertSame('isOk', $this->container->getParameter('my.param'));
    }

    public function test_set_parameter_fail(): void
    {
        self::expectException(AlreadySetParameterException::class);
        $this->container->setParameter('my.param', 'isOk');
        $this->container->setParameter('my.param', 'isOk2');
    }

    public function test_get_parameter_not_found(): void
    {
        self::expectException(NotFoundException::class);
        $this->container->getParameter('is.test');
    }

    public function test_get_set_service_ok(): void
    {
        $this->container->setParameter('test', 'myTest');
        $this->container->set(SampleService::class, static function (ContainerInterface $container) {
            return new SampleService($container->getParameter('test'));
        });
        $serviceCreated = $this->container->get(SampleService::class);
        self::assertEquals(SampleService::class, get_class($serviceCreated));
        self::assertEquals('myTest', $serviceCreated->sampleStringProperty);
    }

    public function test_service_not_found(): void
    {
        self::expectException(NotFoundException::class);
        $this->container->get(SampleService::class);
    }

    public function test_service_is_shared(): void
    {
        $this->container->set(SampleService::class, fn(ContainerInterface $container) => new SampleService('ok'));
        $service = $this->container->get(SampleService::class);
        self::assertSame($service, $this->container->get(SampleService::class));
    }

    public function test_service_is_not_shared(): void
    {
        $this->container->set(SampleService::class, fn(ContainerInterface $container) => new SampleService('ok'), false);
        $service = $this->container->get(SampleService::class);
        self::assertInstanceOf(SampleService::class, $service);
        self::assertNotSame($service, $this->container->get(SampleService::class));
    }
}
