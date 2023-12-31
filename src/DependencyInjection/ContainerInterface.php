<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Describe the Container with possibility to have parameters
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * Finds a parameter of the container by its identifier and returns it.
     *
     * @param string $parameterName Identifier of the parameter
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function getParameter(string $parameterName): mixed;

    /**
     * Returns true if the container can return a parameter for the given identifier.
     * Returns false otherwise.
     *
     * @param string $parameterName Identifier of the parameter
     *
     * @return bool
     */
    public function hasParameter(string $parameterName): bool;

    /**
     * @param string $id
     * @param object $value
     * @param bool $isShared
     * @param array<string> $tags
     * @return void
     */
    public function set(string $id, object $value, bool $isShared = true, array $tags = []): void;

    public function setParameter(string $parameterName, mixed $value): void;

    /**
     *
     * @param array<string> $providers
     */
    public function registerProviders(array $providers): void;

    public function registerProvider(ServiceProviderInterface $provider): void;
}
