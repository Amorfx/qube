<?php

declare(strict_types=1);

namespace Amorfx\Qube\Tests\Fixtures;

use Amorfx\Qube\Contracts\Service\ServiceSubscriberInterface;
use Amorfx\Qube\Contracts\Service\ServiceSubscriberTrait;

class SampleServiceSubscriberBench implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function getCurrentID(): int
    {
        return $this->locator->get(SampleContextService::class)->currentID(); // @phpstan-ignore-line
    }

    public static function getSubscribedServices(): array
    {
        return [SampleContextService::class];
    }
}
