<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection;

/**
 * It describes a little container that can only get service
 */
interface ServiceLocatorInterface
{
    public function get(string $id): object;
}
