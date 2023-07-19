<?php

namespace Amorfx\Qube\Tests;

use Amorfx\Qube\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;
use function Amorfx\Qube\qube;

class HelpersTest extends TestCase
{
    public function test_qube_helper_returns_container_instance()
    {
        $this->assertInstanceOf(Container::class, qube());
    }

    public function test_qube_helper_returns_same_container_instance()
    {
        $container = qube();
        $this->assertSame($container, qube());
    }
}
