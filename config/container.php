<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->useAutowiring(true);

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

return $builder->build();
