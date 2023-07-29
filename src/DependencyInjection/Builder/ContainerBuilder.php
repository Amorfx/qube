<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection\Builder;

use Amorfx\Qube\DependencyInjection\Container;
use Amorfx\Qube\DependencyInjection\ContainerInterface;
use Exception;

class ContainerBuilder
{
    private ContainerInterface $container;

    /**
     * @param string $configFilePath
     * @param array<string, mixed> $config
     */
    public function __construct(
        private string $configFilePath = '',
        private array $config = [],
    ) {
    }

    public function fromConfig(string $configFilePath): self
    {
        $this->configFilePath = $configFilePath;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function get(): Container
    {
        $this->container = new Container();

        if (! empty($this->configFilePath)) {
            $this->config = require $this->configFilePath;
        }

        if (! empty($this->config)) {
            $this->processProviders()
                ->processParams()
                ->processServices();
        }

        return $this->container;
    }

    private function processProviders(): self
    {
        $hasProviders = array_key_exists('providers', $this->config) && ! empty($this->config['providers']);

        if ($hasProviders) {
            $this->container->registerProviders($this->config['providers']);
        }

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

    /**
     * @throws Exception
     */
    private function processServices(): void
    {
        if (! array_key_exists('services', $this->config) || empty($this->config['services'])) {
            return;
        }

        foreach ($this->config['services'] as $id => $arrayServiceConfig) {
            $isShared = $arrayServiceConfig['shared'] ?? true;
            $tags = $arrayServiceConfig['tags'] ?? [];
            if (isset($arrayServiceConfig['factory'])) {
                $value = $arrayServiceConfig['factory'];
            } elseif (isset($arrayServiceConfig['object'])) {
                $value = $arrayServiceConfig['object'];
            } else {
                throw new Exception('Invalid service configuration. You must have a factory or object key.');
            }

            $this->container->set($id, $value, $isShared, $tags);
        }

    }
}
