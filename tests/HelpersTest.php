<?php

declare(strict_types=1);

namespace Amorfx\Qube\Tests;

use Amorfx\Qube\DependencyInjection\Container;

use function Amorfx\Qube\qube;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function test_qube_helper_returns_container_instance(): void
    {
        $this->assertInstanceOf(Container::class, qube());
    }

    public function test_qube_helper_returns_same_container_instance(): void
    {
        $container = qube();
        $this->assertSame($container, qube());
    }
}
