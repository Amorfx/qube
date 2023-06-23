<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection;

use Closure;

/**
 * A definition describe a Service
 * - The service can be shareable or not (only one instance or not)
 * - Have the factory method
 */
class Definition
{
    public function __construct(
        private readonly Closure $factory,
        private readonly bool $isShared = true
    ) {
    }

    public function create(ContainerInterface $container): object
    {
        return ($this->factory)($container);
    }

    public function isShared(): bool
    {
        return $this->isShared;
    }
}
