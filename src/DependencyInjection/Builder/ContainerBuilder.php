<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection\Builder;

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

            $this
                ->processProviders($config)
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
        foreach ($config['parameters'] as $id => $value) {
            $this->container->setParameter($id, $value);
        }

        return $this;
    }
}
