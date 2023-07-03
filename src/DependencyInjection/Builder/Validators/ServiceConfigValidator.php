<?php

declare(strict_types=1);

namespace Amorfx\Qube\DependencyInjection\Builder\Validators;

class ServiceConfigValidator
{
    public function validateOrThrow(array $payload): bool
    {
        $keys = array_keys($payload);
    }
}