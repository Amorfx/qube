<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection\Builder\Validators;

use Closure;
use InvalidArgumentException;

class ServiceConfigValidator
{
    public function validateOrThrow(array $payload): void
    {
        $keys = array_keys($payload);
        $expectedKeys = ['factory', 'object', 'tags', 'shared'];
        $diff = array_diff($keys, $expectedKeys);

        if (! empty($diff)) {
            throw new InvalidArgumentException('Parameters for services config keys ' . implode(', ', $diff) . ' are not allowed. Availables keys are ' . implode(', ', $expectedKeys));
        }

        // Verify factory or object
        $haveFactory = in_array('factory', $keys);
        $haveObject = in_array('object', $keys);
        $shouldHaveFactoryOrObject = $haveFactory || $haveObject;
        if (! $shouldHaveFactoryOrObject) {
            throw new InvalidArgumentException('A service configuration should have factory or object.');
        }

        $object = $this->getObjectForService($payload, $haveFactory, $haveObject);
    }

    private function getObjectForService(array $payload, bool $haveFactory, bool $haveObject): object
    {
        $object = null;
        if ($haveFactory) {
            if (! $payload['factory'] instanceof Closure) {
                throw new InvalidArgumentException('A service factory must be a Closure.');
            }
            $object = $payload['factory'];
        }

        if ($haveObject) {
            if (! is_object($payload['object']) || $payload['object'] instanceof Closure) {
                throw new InvalidArgumentException('A service object must be an instance of a class but not of Closure object.');
            }

            $object = $payload['object'];

        }

        return $object;
    }
}
