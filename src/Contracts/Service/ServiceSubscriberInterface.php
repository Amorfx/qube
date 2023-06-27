<?php

declare(strict_types=1);

namespace Amorfx\Qube\Contracts\Service;

use Amorfx\Qube\DependencyInjection\ServiceLocatorInterface;

interface ServiceSubscriberInterface
{
    /**
     * Return all service that the service use
     * @return array<string>
     */
    public static function getSubscribedServices(): array;

    public function setLocator(ServiceLocatorInterface $serviceLocator): void;
}
