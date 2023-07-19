<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection\Builder;

use Amorfx\Qube\DependencyInjection\Builder\Validators\ServiceConfigValidator;
use Amorfx\Qube\DependencyInjection\Container;
use Amorfx\Qube\DependencyInjection\ContainerInterface;

class ContainerBuilder
{
    public function __construct(
        private string $configFilePath = '',
        private array $config = [],
        private ?ContainerInterface $container = null
    ) {
    }

    public function fromConfig(string $configFilePath): self
    {
        $this->configFilePath = $configFilePath;

        return $this;
    }

    public function get(): ContainerInterface
    {
        $this->container = new Container();

        if (! empty($this->configFilePath)) {
            $this->config = require $this->configFilePath;

            $this->processProviders()
                ->processParams()
                ->processServices();
        }

        return $this->container;
    }

    private function processProviders(): self
    {
        $hasProviders = array_key_exists('providers', $this->config) && ! empty($this->config['providers']);

        return $this;
    }

    private function processParams(): self
    {
        if (! array_key_exists('parameters', $this->config) || empty($this->config['parameters'])) {
            return $this;
        }

        foreach ($this->config['parameters'] as $id => $value) {
            $this->container->setParameter($id, $value);
        }

        return $this;
    }

    private function processServices(): self
    {
        if (! array_key_exists('services', $this->config) || empty($this->config['services'])) {
            return $this;
        }

        $serviceConfigValidator = new ServiceConfigValidator();

        foreach ($this->config['services'] as $id => $arrayServiceConfig) {
            $serviceConfigValidator->validateOrThrow($arrayServiceConfig);


        }

        return $this;
    }
}
