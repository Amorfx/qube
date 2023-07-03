<?php

declare(strict_types=1);

namespace Amorfx\Qube\Tests\Fixtures;

use Amorfx\Qube\DependencyInjection\ContainerInterface;
use Amorfx\Qube\DependencyInjection\ServiceProviderInterface;

class SampleServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $container): void
    {
        $container->set(SampleService::class, static function (ContainerInterface $container) {
            return new SampleService('the_test');
        });
    }
}
