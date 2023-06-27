<?php

declare(strict_types=1);

namespace Amorfx\Qube\Tests\DependencyInjection;

use Amorfx\Qube\DependencyInjection\Definition;
use PHPUnit\Framework\TestCase;

class DefinitionTest extends TestCase
{
    public function test_it_initiate_is_shared_correctly(): void
    {
        $definition = new Definition(function () {}, false);
        self::assertFalse($definition->isShared());
    }

    public function test_it_is_shared_default_true(): void
    {
        $definition = new Definition(function () {});
        self::assertTrue($definition->isShared());
    }
}
