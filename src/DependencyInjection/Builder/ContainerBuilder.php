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
            $config = require $this->configFilePath;

            if (! is_array($config)) {
                throw new \Exception('Config is not an array'); // TODO change type exception
            }

            $this->processProviders($config)
                ->processParams($config);
        }

        return $this->container;
    }

    private function processProviders(array $config): self
    {
        $hasProviders = array_key_exists('providers', $config) && ! empty($config['providers']);

        return $this;
    }

    private function processParams(array $config): self
    {
        if (! array_key_exists('parameters', $config) || empty($config['parameters'])) {
            return $this;
        }

        foreach ($config['parameters'] as $id => $value) {
            $this->container->setParameter($id, $value);
        }

        return $this;
    }

    private function processServices(array $config): self
    {
        if (! array_key_exists('services', $config) || empty($config['services'])) {
            return $this;
        }

        $serviceConfigValidator = new ServiceConfigValidator();

        foreach ($config['services'] as $id => $arrayServiceConfig) {
            $serviceConfigValidator->validateOrThrow($arrayServiceConfig);

            $this->container->set($id, $factory);
        }

        return $this;
    }
}
