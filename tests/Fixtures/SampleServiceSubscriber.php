<?php

declare(strict_types=1);

namespace Amorfx\Qube\Tests\Fixtures;

use Amorfx\Qube\Contracts\Service\ServiceSubscriberInterface;
use Amorfx\Qube\Contracts\Service\ServiceSubscriberTrait;

class SampleServiceSubscriber implements ServiceSubscriberInterface, SampleInterface
{
    use ServiceSubscriberTrait;

    public function getSampleServiceProperty(): string
    {
        return $this->locator->get(SampleService::class)->sampleStringProperty;  // @phpstan-ignore-line
    }

    public function getCurrentID(): int
    {
        return $this->locator->get(SampleContextService::class)->currentID(); // @phpstan-ignore-line
    }

    public function getSampleContextService(): SampleContextService
    {
        return $this->locator->get(SampleContextService::class); // @phpstan-ignore-line
    }

    public static function getSubscribedServices(): array
    {
        return [SampleService::class, SampleContextService::class];
    }
}
