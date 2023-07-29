<?php

use Amorfx\Qube\DependencyInjection\ContainerInterface;
use Amorfx\Qube\Tests\Fixtures\SampleService;
use Amorfx\Qube\Tests\Fixtures\SampleServiceProvider;

return [
    'parameters' =>
        [
            'my.id.value' => 'value',
            'blabla' => 'ok',
        ],
    'services' =>
        [
            'my.service.factory' => [
                'factory' => static function (ContainerInterface $container) {
                    return new SampleService('ok');
                },
            ],
            'my.service.not.shared' => [
                'factory' => static function (ContainerInterface $container) {
                    return new SampleService('ok');
                },
                'shared' => false,
            ],
            'my.service.tags' => [
                'factory' => static function (ContainerInterface $container) {
                    return new SampleService('ok');
                },
                'tags' => ['my.tag'],
            ],
        ],
    'providers' =>
    [
        SampleServiceProvider::class,
    ],
];
