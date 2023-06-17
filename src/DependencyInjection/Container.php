<?php

namespace Amorfx\Qube\DependencyInjection;

use Amorfx\Qube\Exceptions\AlreadySetServiceException;
use Amorfx\Qube\Exceptions\NotFoundException;

class Container implements ContainerInterface
{
    private array $services = [];

    private array $parameters = [];

    public function get(string $id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @throws AlreadySetServiceException
     */
    public function set(string $id, mixed $value): void
    {
        if ($this->has($id)) {
            throw new AlreadySetServiceException('The service ' . $id . ' is already set in the container');
        }

        $this->services[$id] = $value;
    }

    public function setParameter(string $parameterName, mixed $value): void
    {
        // TODO: Implement setParameter() method.
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
}
