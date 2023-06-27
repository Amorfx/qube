<?php

declare(strict_types=1);

namespace Amorfx\Qube\Contracts\Service;

use Amorfx\Qube\DependencyInjection\ServiceLocatorInterface;

trait ServiceSubscriberTrait
{
    protected ServiceLocatorInterface $locator;

    public function setLocator(ServiceLocatorInterface $locator): void
    {
        $this->locator = $locator;
    }
}
