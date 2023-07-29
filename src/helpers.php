<?php

declare(strict_types=1);

namespace Amorfx\Qube;

use Amorfx\Qube\DependencyInjection\Builder\ContainerBuilder;
use Amorfx\Qube\DependencyInjection\Container;

function qube(): Container
{
    static $container;

    if (! $container instanceof Container) {
        $container = new Container();
    }

    return $container;
}

function quBuilder(): ContainerBuilder
{
    return new ContainerBuilder();
}
