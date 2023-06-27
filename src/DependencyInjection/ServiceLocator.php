<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection;

class ServiceLocator implements ServiceLocatorInterface
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
    }

    public function get(string $id): object
    {
        return $this->container->get($id);
    }
}
