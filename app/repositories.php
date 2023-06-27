<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Domain\Sensor\SensorRepository;
use App\Infrastructure\Persistence\Sensor\InMemorySensorRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        SensorRepository::class => \DI\autowire(InMemorySensorRepository::class),
    ]);
};
