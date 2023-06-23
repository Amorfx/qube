<?php

namespace Amorfx\Qube\Tests\Benchmark;

use Amorfx\Qube\DependencyInjection\Container;
use Amorfx\Qube\DependencyInjection\ContainerInterface;
use Amorfx\Qube\Tests\Fixtures\SampleService;

class MemoryConsumeBench
{
    /**
     * @Revs(1000)
     */
    public function bench_simple_container_get_param(): void
    {
        $container = new Container();
        $container->setParameter('test', 'myTest');
        $container->getParameter('test');
    }

    /**
     * @Revs(100)
     */
    public function bench_big_container_get_service(): void
    {
        $container = new Container();
        foreach (range(0, 1500) as $number) {
            $container->set('service.' . $number, static function (ContainerInterface $container) use ($number) {
                return new SampleService($container->getParameter('number' . $number));
            });
            $container->setParameter('number' . $number, $number);
            $container->get('service.' . $number);
        }
    }

    /**
     * @Revs(100)
     */
    public function bench_big_container_get_service_tags(): void
    {
        $container = new Container();
        foreach (range(0, 1500) as $number) {
            $container->set('service.' . $number, static function (ContainerInterface $container) use ($number) {
                return new SampleService($container->getParameter('number' . $number));
            }, tags: ['service' . $number % 2]);
            $container->setParameter('number' . $number, $number);
        }

        $container->getByTag('service0');
    }
}
