<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection;

/**
 * Group registered service, params or other providers
 */
interface ServiceProviderInterface
{
    public function register(ContainerInterface $container): void;
}
