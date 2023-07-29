<?php

declare(strict_types=1);

namespace Amorfx\Qube\Tests\DependencyInjection\Builder;

use Amorfx\Qube\DependencyInjection\Builder\ContainerBuilder;
use Amorfx\Qube\Tests\Fixtures\SampleService;
use PHPUnit\Framework\TestCase;

class ContainerBuilderTest extends TestCase
{
    private ContainerBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new ContainerBuilder(__DIR__ . '/../../Fixtures/Builder/config-sample.php');
    }

    public function test_it_process_parameters(): void
    {
        $container = $this->builder->get();
        self::assertEquals('value', $container->getParameter('my.id.value'));
        self::assertEquals('ok', $container->getParameter('blabla'));
    }

    public function test_it_process_service_with_factory(): void
    {
        $container = $this->builder->get();
        $service = $container->get('my.service.factory');
        self::assertInstanceOf(SampleService::class, $service);
        self::assertSame('ok', $service->sampleStringProperty);
    }

    public function test_it_process_service_with_object(): void
    {
        $service = new SampleService('value');
        $config = [
            'services' =>
                [
                    'my.service.object' => [
                        'object' => $service,
                    ],
                ],
        ];
        $container = (new ContainerBuilder(config: $config))->get();
        self::assertSame($service, $container->get('my.service.object'));
    }

    public function test_it_process_service_not_shared(): void
    {
        $container = $this->builder->get();
        $service1 = $container->get('my.service.not.shared');
        $service2 = $container->get('my.service.not.shared');
        self::assertInstanceOf(SampleService::class, $service1);
        self::assertInstanceOf(SampleService::class, $service2);
        self::assertNotSame($service1, $service2);
    }

    public function test_it_process_service_with_tags(): void
    {
        $container = $this->builder->get();
        $services = $container->getByTag('my.tag');
        $services = iterator_to_array($services);
        self::assertCount(1, $services);
        self::assertInstanceOf(SampleService::class, $services[0]);
    }

    public function test_it_process_providers(): void
    {
        $container = $this->builder->get();
        $service = $container->get(SampleService::class);
        self::assertInstanceOf(SampleService::class, $service);
        self::assertSame('the_test', $service->sampleStringProperty);
    }
}
