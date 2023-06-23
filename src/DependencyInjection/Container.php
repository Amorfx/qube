<?php

namespace Amorfx\Qube\DependencyInjection;

use Amorfx\Qube\Exceptions\AlreadySetParameterException;
use Amorfx\Qube\Exceptions\AlreadySetServiceException;
use Amorfx\Qube\Exceptions\NotFoundException;
use Closure;

class Container implements ContainerInterface
{
    /**
     * @var array<object>
     */
    private array $services = [];

    /**
     * @var array <string, array<string>>
     */
    private array $tagsServiceBags = [];

    /**
     * @var array<mixed>
     */
    private array $parameters = [];

    public function get(string $id)
    {
        if (! $this->has($id)) {
            throw new NotFoundException('The service ' . $id . ' is not bind in the container. Please use set function.');
        }

        $service = $this->services[$id];
        if ($service instanceof Definition) {
            $definition = $service;
            $service = $definition->create($this);

            if ($definition->isShared()) {
                $this->services[$id] = $service;
            }
        }

        return $service;
    }

    /**
     * @param string $id
     * @param object $value
     * @param bool $isShared
     * @param array<string> $tags
     * @return void
     * @throws AlreadySetServiceException
     */
    public function set(string $id, object $value, bool $isShared = true, array $tags = []): void
    {
        if ($this->has($id)) {
            throw new AlreadySetServiceException('The service ' . $id . ' is already set in the container');
        }

        if (! empty($tags)) {
            foreach ($tags as $tagName) {
                $this->addServiceToTag($tagName, $id);
            }
        }

        if ($value instanceof Closure) {
            $this->services[$id] = new Definition($value, $isShared);

            return;
        }

        $this->services[$id] = $value;
    }

    public function setParameter(string $parameterName, mixed $value): void
    {
        if ($this->hasParameter($parameterName)) {
            throw new AlreadySetParameterException('The parameter ' . $parameterName . ' is already set with the value ' . $this->getParameter($parameterName));
        }

        $this->parameters[$parameterName] = $value;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    public function getParameter(string $parameterName): mixed
    {
        if (! $this->hasParameter($parameterName)) {
            throw new NotFoundException("The parameter " . $parameterName . ' not found.');
        }

        return $this->parameters[$parameterName];
    }

    public function hasParameter(string $parameterName): bool
    {
        return array_key_exists($parameterName, $this->parameters);
    }

    private function addServiceToTag(string $tagName, string $serviceId): void
    {
        if (! array_key_exists($tagName, $this->tagsServiceBags)) {
            $this->tagsServiceBags[$tagName] = [];
        }

        if (in_array($serviceId, $this->tagsServiceBags[$tagName])) {
            return;
        }

        $this->tagsServiceBags[$tagName][] = $serviceId;
    }

    /**
     * @param string $tagName
     * @return array<object>
     * @throws NotFoundException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getByTag(string $tagName): array
    {
        if (! array_key_exists($tagName, $this->tagsServiceBags)) {
            throw new NotFoundException('The tag ' . $tagName . ' not exist in container. Have you set a service with this tag ?');
        }

        $services = [];
        foreach ($this->tagsServiceBags[$tagName] as $serviceId) {
            $services[] = $this->get($serviceId);
        }

        return $services;
    }
}
